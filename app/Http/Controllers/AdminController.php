<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailNotify;
use Exception;
/* Model Import */
Use App\Model\User;
Use App\Model\FixedCost;
Use App\Model\DailyCost;
Use App\Model\Category;
Use App\Model\Installment;
Use App\Model\InstallmentDetail;

class AdminController extends Controller
{
    public function getFixedCostView() {
        $this->data['costs'] = FixedCost::all();
        return view('pages.admin.fixed_cost_view')->with($this->data);
    }

    public function getDailyCostView() {
        $this->data['month'] = date('m');
        $this->data['year'] = date('Y');
        $this->data['together'] = config('constants.COST_TYPE.TOGETHER');
        $this->data['costs'] = DB::table('daily_costs')
                                    ->whereRaw(DB::raw('MONTH(date) = '.$this->data['month'].' and YEAR(date) = '.$this->data['year'].' and deleted_at is null and daily_costs.percent_per_one > 0 AND daily_costs.percent_per_two > 0'))
                                    ->where('payer', Auth::user()->id)
                                    ->join('users','daily_costs.payer','=','users.id')
                                    ->select('daily_costs.*','users.name')
                                    ->get();
        return view('pages.admin.daily_cost_view')->with($this->data);
    }

    public function getAddDailyCostView($together) {
        $this->data['users'] = User::all();
        $this->data['categories'] = Category::all();
        $this->data['installments'] = Installment::with(['detail'])->get();
        // $this->data['ins_details'] = InstallmentDetail::all();
        $this->data['together'] = $together;
        return view('pages.admin.add_daily_cost')->with($this->data);
    }

    public function addDailyCost(Request $re) {
        try {
            DB::beginTransaction();
            $daily = new DailyCost;
            $daily->payfor = $re->payfor;
            $daily->payer = $re->payer;
            $daily->date = $re->date;
            $daily->total = $re->total;

            $togetherFlg = $re->is_together;
            if ($togetherFlg == 1) {
                $daily->percent_per_one = $re->percent_per_one;
                $daily->percent_per_two = $re->percent_per_two;
                $daily->total_per_one = ($re->total * ($re->percent_per_one/100));
                $daily->total_per_two = ($re->total * ($re->percent_per_two/100));
                $daily->is_together = 1;
                $daily->category = null;
            } else {
                if ($re->payer == 1) {
                    $daily->percent_per_one = 100;
                    $daily->percent_per_two = 0;
                    $daily->total_per_one = $re->total;
                    $daily->total_per_two = 0;
                } else {
                    $daily->percent_per_one = 0;
                    $daily->percent_per_two = 100;
                    $daily->total_per_two = $re->total;
                    $daily->total_per_one = 0;
                }
                $daily->is_together = 0;
                $daily->category = $re->category;
            }

            if($re->hasFile('image')){
                $file = $re->file('image');
                $duoi = $file->getClientOriginalExtension();
                $name = $file->getClientOriginalName();
                $img = str_random(4)."_".$name;
                while (file_exists("img/".$img)) {
                $img = str_random(4)."_".$name;
                }
                $file->move("img",$img);
                $daily->image = $img;
            }
    
            $daily->save();

            if($re->ins_detail_id) {
                // $insDetail = InstallmentDetail::with(['installment'])->where('id',$re->ins_detail_id)->get();
                $insDetail = InstallmentDetail::find($re->ins_detail_id);
                $insDetail->status = 1;
                
    
                $installment = Installment::find($insDetail->installment_id);
                if ($installment->waiting_amout != 0) {
                    $installment->waiting_amout = $installment->waiting_amout - $insDetail->trans_amout;
                } else {
                    $installment->waiting_amout = $installment->trans_amout - $insDetail->trans_amout;
                }
                
                $insDetail->save();
                $installment->save();
            }
            
            DB::commit();
            return redirect()->back()->with('success','Thêm thành công!');
        } catch (Exception $ex) {
            DB::rollback();
            return redirect()->back()->with('error','Thêm Thất bại!');
        }
    }

    public function getEditDailyCostView($id,$together) {
        $this->data['oldCost'] = DailyCost::find($id);
        // return $this->data;
        $this->data['users'] = User::all();
        $this->data['categories'] = Category::all();
        $this->data['together'] = $together;
        return view('pages.admin.edit_daily_cost')->with($this->data);
    }

    public function editDailyCost($id, Request $re) {
        try {
            DB::beginTransaction();
            $oldDaily = DailyCost::find($id);
            $oldDaily->payfor = $re->payfor;
            $oldDaily->payer = $re->payer;
            $oldDaily->date = $re->date;
            $oldDaily->total = $re->total;
            $togetherFlg = $re->is_together;
            if ($togetherFlg == 1) {
                $oldDaily->percent_per_one = $re->percent_per_one;
                $oldDaily->percent_per_two = $re->percent_per_two;
                $oldDaily->total_per_one = ($re->total * ($re->percent_per_one/100));
                $oldDaily->total_per_two = ($re->total * ($re->percent_per_two/100));
                $oldDaily->is_together = 1;
                $oldDaily->category = null;
            } else {
                if ($re->payer == 1) {
                    $oldDaily->percent_per_one = 100;
                    $oldDaily->percent_per_two = 0;
                    $oldDaily->total_per_one = $re->total;
                    $oldDaily->total_per_two = 0;
                } else {
                    $oldDaily->percent_per_one = 0;
                    $oldDaily->percent_per_two = 100;
                    $oldDaily->total_per_two = $re->total;
                    $oldDaily->total_per_one = 0;
                }
                $oldDaily->is_together = 0;
                $oldDaily->category = $re->category;
            }

            $dltFlg = $re->img_dlt_flg;
            if($re->hasFile('image')){
                $file = $re->file('image');
                $duoi = $file->getClientOriginalExtension();
                $name = $file->getClientOriginalName();
                $img = str_random(4)."_".$name;
                // while (file_exists("img/".$oldDaily->image)) {
                //     if ($oldDaily->image != null) {
                //         unlink("img/".$oldDaily->image);
                //     }
                // }
                $file->move("img",$img);
                $oldDaily->image = $img;
            } else {
                if ($dltFlg) {
                    // if ($oldDaily->image != null) {
                    //     unlink("img/".$oldDaily->image);
                    // }
                    $oldDaily->image = null;
                }
            }

            $oldDaily->save();
            DB::commit();
            return redirect()->back()->with('success','Cập nhật thành công!');
        } catch (Exception $ex) {
            DB::rollback();
            return redirect()->back()->with('error','Cập nhật Thất bại!');
        }
    }

    public function deleteDailyCost($id) {
        try {
            DB::beginTransaction();
            $cost = DailyCost::find($id);
            $cost->delete();
            DB::commit();
            return redirect()->back()->with('success','Xóa thành công!');
        } catch (Exception $ex) {
            DB::rollback();
            return redirect()->back()->with('error','Xóa Thất bại!');
        }
    }

    public function personalDailyCost() {
        $this->data['month'] = date('m');
        $this->data['year'] = date('Y');
        $this->data['together'] = config('constants.COST_TYPE.PERSONAL');
        $condition = DB::raw('MONTH(date) = '.$this->data['month'].' and YEAR(date) = '.$this->data['year'].' and deleted_at is null');

        if (Auth::user()->id == 1) {
            $condition .= DB::raw(' and daily_costs.percent_per_two = 0');
        } else {
            $condition .= DB::raw(' and daily_costs.percent_per_one = 0');
        }
        $this->data['costs'] = DB::table('daily_costs')
                                    ->whereRaw($condition)
                                    ->where('payer', Auth::user()->id)
                                    ->join('users','daily_costs.payer','=','users.id')
                                    ->select('daily_costs.*','users.name')
                                    ->get();
        return view('pages.admin.daily_cost_view')->with($this->data);
    }

    public function getMonthlyCostView($month = 6, $year = 2020) {
        $this->data['costs'] = DB::table('daily_costs')
                                    ->whereRaw(DB::raw('MONTH(date) = '.$month.' and YEAR(date) = '.$year.' and deleted_at is null and daily_costs.is_together = 0'))
                                    ->join('users','daily_costs.payer','=','users.id')
                                    ->select('daily_costs.*','users.name')
                                    ->get();
        $this->data['costs'] = $this->data['costs']->groupBy('date');
        $this->data['costs']->toJson();
        // return $this->data['costs'];
        $this->data['month'] = $month;
        $this->data['year'] = $year;
        $this->data['together'] = config('constants.COST_TYPE.PERSONAL');
        $this->data['users'] = User::all();
        // return $this->data;
        return view('pages.admin.monthly_cost_view')->with($this->data);
    }

    public function filterMonthlyCost(Request $re) {
        $condition = DB::raw('MONTH(date) = '.$re->month.' and YEAR(date) = '.$re->year.' and deleted_at is null');

        if ($re->together == config('constants.COST_TYPE.TOGETHER')) {
            $condition .= DB::raw(' and daily_costs.is_together = 1');
        } else if ($re->together == config('constants.COST_TYPE.PERSONAL')) {
            if (Auth::user()->id == 1) {
                $condition .= DB::raw(' and daily_costs.is_together = 0 AND daily_costs.payer = '.Auth::user()->id);
            } else if (Auth::user()->id == 2) {
                $condition .= DB::raw(' and daily_costs.is_together = 0 AND daily_costs.payer = '.Auth::user()->id);
            }
        }
        $this->data['costs'] = DB::table('daily_costs')
                                    ->whereRaw($condition)
                                    ->join('users','daily_costs.payer','=','users.id')
                                    ->select('daily_costs.*','users.name')
                                    ->get();

        $this->data['costs'] = $this->data['costs']->groupBy('date');
        $this->data['costs']->toJson();

        $this->data['month'] = $re->month;
        $this->data['year'] = $re->year;
        $this->data['together'] = $re->together;
        // return view('pages.admin.test')->with($this->data);
        return view('pages.admin.monthly_cost_view')->with($this->data);
    }

    public function filterDailyCost(Request $re) {
        $condition = DB::raw('MONTH(date) = '.$re->month.' and YEAR(date) = '.$re->year.' and deleted_at is null and daily_costs.payer = '.Auth::user()->id);
        $this->data['costs'] = DB::table('daily_costs')
                                    ->whereRaw($condition)
                                    ->join('users','daily_costs.payer','=','users.id')
                                    ->select('daily_costs.*','users.name')
                                    ->orderBy('id', 'desc')
                                    ->get();
        $this->data['month'] = $re->month;
        $this->data['year'] = $re->year;
        $this->data['together'] = $re->together;
        return view('pages.admin.daily_cost_view')->with($this->data);
    }

    public function sendMail() {
        $costs = DB::table('daily_costs')
        ->whereRaw(DB::raw('MONTH(date) = 4 and YEAR(date) = '.date('Y').' and deleted_at is null'))
        ->join('users','daily_costs.payer','=','users.id')
        ->selectRaw('sum(daily_costs.total_per_one) AS total_per_one, sum(daily_costs.total_per_two) AS total_per_two')
        ->get();

        $totalOne = 0;
        $totalTwo = 0;
        foreach ($costs as $cost) {
            $totalOne += $cost->total_per_one;
            $totalTwo += $cost->total_per_two;
        }

        $data = array(
            'costs' => $costs,
        );
        Mail::to('kiet1022@gmail.com')->send(new MailNotify($data, 'Dương Tuấn Kiệt', $totalOne));
        // Mail::to('hoangthach1399@gmail.com')->send(new MailNotify($data, 'Dương Tuấn Kiệt', $totalTwo));
    }

    public function getInstallmentList() {
        $this->data['installments'] = Installment::where('payer', Auth::user()->id)->get();
        return view('pages.admin.installment_list')->with($this->data);
    }

    public function getAddInstallmentList() {
        return view('pages.admin.add_installment_list');
    }

    public function AddInstallmentList(Request $re) {
        try {

            DB::beginTransaction();
            $installment = new Installment;
            $installment->details = $re->details;
            $installment->trans_date = $re->trans_date;
            $installment->trans_amout = $re->trans_amount;
            $installment->waiting_amout = $re->trans_amount;
            $installment->start_date = $re->start_date;
            $installment->due_date = $re->due_date;
            $installment->cycle = $re->cycle;
            $installment->payer = Auth::user()->id;
            $installment->save();

            $arr_date = [];
            $temp_date = $re->start_date;
            for($index = 0; $index < $re->cycle; $index++){
                array_push($arr_date, $temp_date);
                $temp_date =  date('Y-m-d', strtotime("+1 months", strtotime($temp_date)));
            }

            forEach($arr_date as $date) {
                $ins_detail = new InstallmentDetail;
                $ins_detail->installment_id = $installment->id;
                $ins_detail->pay_date = $date;
                $ins_detail->trans_amout = $re->trans_amount/$re->cycle;
                $ins_detail->status = 0;
                $ins_detail->payer = Auth::user()->id;
                $ins_detail->save();
            }

            
            DB::commit();
            return redirect()->back()->with('success','Thêm thành công!');
        } catch (Exception $ex) {
            DB::rollback();
            return redirect()->back()->with('error',$ex->getMessage());
        }
    }

    public function InstallmentDetail($id) {
        $installment = Installment::find($id);
        $details = InstallmentDetail::where('installment_id',$id)->get();
        
        $this->data['installment'] = $installment;
        $this->data['ins_detail'] = $details;
        $this->data['cost_per_month'] = round($installment->trans_amout / $installment->cycle, 2);
        // return $this->data;
        return view('pages.admin.installment_detail')->with($this->data);
    }

    public function AjaxInstallmentDetail(Request $re) {
        $ins_detail = InstallmentDetail::where('installment_id', $re->id)->get();
        return response()->json(['detail'=>$ins_detail]);
    }

}
