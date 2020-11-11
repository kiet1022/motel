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
Use App\Model\StorageManager;
Use App\Model\Balance;

/* Request Import */
Use App\Http\Requests\BalanceRequest;
Use App\Http\Requests\AddDailyCostRequest;

class AdminController extends Controller
{

    public function getDashboard(){
        $date = date("Y-m-d");
        $this->data['coffee'] = DB::table('daily_costs')
                                    ->whereRaw(DB::raw("payfor like '%cà phê sáng%' AND date = '$date'"))
                                    ->select('daily_costs.*')->count();
        if($this->data['coffee'] == 1) {
            return view('pages.admin.dashboard')->with($this->data);
        } else {
            if (session('coffee') == 1) {
                $this->data['coffee'] =  1;
            }
        }
        return view('pages.admin.dashboard')->with($this->data);
    }

    public function saveMorningCoffee(Request $re){
        if ($re->flg == 1) {
            try {
                DB::beginTransaction();
                $daily = new DailyCost;
                $daily->payfor = "Cà phê sáng";
                $daily->payer = Auth::user()->id;
                $daily->date = date('Y-m-d');
                $daily->total = 15000;
                $daily->is_together = 0;
                $daily->category = 1;
                if (Auth::user()->id == 1) {
                    $daily->percent = "100,0";
                } else {
                    $daily->percent = "0,100";
                }
                $daily->save();
                $re->session()->put('coffee', 1);
                DB::commit();
                return redirect()->route('get_dashboard');
            } catch (Exception $ex) {
                DB::rollback();
                $re->session()->put('coffee',0);
                return redirect()->route('get_dashboard');
            }
        } else {
            $re->session()->put('coffee', 1);
            return redirect()->route('get_dashboard');
        }
    }

    public function getFixedCostView() {
        $this->data['costs'] = FixedCost::all();
        return view('pages.admin.fixed_cost_view')->with($this->data);
    }

    public function getDailyCostView() {
        $this->data['month'] = date('m');
        $this->data['year'] = date('Y');
        $this->data['together'] = config('constants.COST_TYPE.TOGETHER');
        $this->data['costs'] = DB::table('daily_costs')
                                    ->whereRaw(DB::raw('MONTH(date) = '.$this->data['month'].' and YEAR(date) = '.$this->data['year'].' and deleted_at is null and daily_costs.is_together = '.config('constants.COST_TYPE.TOGETHER')))
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

    public function addDailyCost(AddDailyCostRequest $re) {
        try {
            DB::beginTransaction();
            $daily = new DailyCost;
            $daily->payfor = $re->payfor;
            $daily->payer = $re->payer;
            $daily->date = $re->date;
            $daily->total = $re->total;
            $daily->percent = join(',', $re->percent);

            $togetherFlg = $re->is_together;
            $daily->is_together = $togetherFlg;

            if ($togetherFlg == 0) {
                $daily->category = $re->category;
                if ($re->payer == 1) {
                    $daily->percent = "100,0";
                } else {
                    $daily->percent = "0,100";
                }
            } else {
                $daily->category = null;
            }

            if($re->hasFile('image')){
                $file = $re->file('image');
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
            // return redirect()->back()->with('error','Thêm Thất bại!');
            return redirect()->back()->with('error',$ex->getMessage());
        }
    }

    public function getEditDailyCostView($id,$together) {
        $this->data['oldCost'] = DailyCost::find($id);
        $this->data['installments'] = Installment::with(['detail'])->get();
        // return $this->data;
        $this->data['users'] = User::all();
        $this->data['categories'] = Category::all();
        $this->data['together'] = $together;
        return view('pages.admin.edit_daily_cost')->with($this->data);
    }

    public function editDailyCost($id, AddDailyCostRequest $re) {
        try {
            DB::beginTransaction();
            $oldDaily = DailyCost::find($id);
            $oldDaily->payfor = $re->payfor;
            $oldDaily->payer = $re->payer;
            $oldDaily->date = $re->date;
            $oldDaily->total = $re->total;
            $oldDaily->percent = join(',', $re->percent);

            $togetherFlg = $re->is_together;
            $oldDaily->is_together = $togetherFlg;

            if ($togetherFlg == 0) {
                $oldDaily->category = $re->category;
                if ($re->payer == 1) {
                    $oldDaily->percent = "100,0";
                } else {
                    $oldDaily->percent = "0,100";
                }
            } else {
                $oldDaily->category = null;
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

            if($re->ins_detail_id) {
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
            return redirect()->back()->with('success','Cập nhật thành công!');
        } catch (Exception $ex) {
            DB::rollback();
            // return redirect()->back()->with('error','Cập nhật Thất bại!');
            return redirect()->back()->with('error',$ex->getMessage());
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

    public function getAddFixedCostView(){
        $this->data['month'] = date('m');
        return view('pages.admin.add_fixed_cost')->with($this->data);
    }

    public function AddFixedCost(Request $re) {
        try {
            DB::beginTransaction();
            // Room fee
            $roomfee = new DailyCost;
            $roomfee->payfor = "Tiền phòng";
            $roomfee->payer = Auth::user()->id;
            $roomfee->date = $re->date;
            $roomfee->total = $re->room_fee;
            $roomfee->percent = "50,50";
            $roomfee->is_together = 1;

            if($re->hasFile('image')){
                $file = $re->file('image');
                $name = $file->getClientOriginalName();
                $img = str_random(4)."_".$name;
                while (file_exists("img/".$img)) {
                $img = str_random(4)."_".$name;
                }
                $file->move("img",$img);
                $roomfee->image = $img;
            }
            $roomfee->save();

            // water fee
            $waterfee = new DailyCost;
            $waterfee->payfor = "Tiền nước";
            $waterfee->payer = Auth::user()->id;
            $waterfee->date = $re->date;
            $waterfee->total = $re->water_fee;
            $waterfee->percent = "50,50";
            $waterfee->is_together = 1;
            $waterfee->save();

            // trash fee
            $trashfee = new DailyCost;
            $trashfee->payfor = "Tiền rác";
            $trashfee->payer = Auth::user()->id;
            $trashfee->date = $re->date;
            $trashfee->total = $re->trash_fee;
            $trashfee->percent = "50,50";
            $trashfee->is_together = 1;
            $trashfee->save();

            // ele fee
            $elefee = new DailyCost;
            $elefee->payfor = "Tiền điện ($re->ele_num ký)";
            $elefee->payer = Auth::user()->id;
            $elefee->date = $re->date;
            $elefee->total = $re->ele_fee;
            $elefee->percent = "50,50";
            $elefee->is_together = 1;
            $elefee->save();

            DB::commit();
            return redirect()->back()->with('success','Thêm thành công!');
        } catch (Exception $ex) {
            DB::rollback();
            return redirect()->back()->with('error','Thêm Thất bại!');
        }
    }

    public function personalDailyCost() {
        $this->data['month'] = date('m');
        $this->data['year'] = date('Y');
        $this->data['together'] = config('constants.COST_TYPE.PERSONAL');

        $condition = DB::raw('MONTH(date) = '.$this->data['month'].' and YEAR(date) = '.
        $this->data['year'].' and deleted_at is null and payer = '.
        Auth::user()->id.' and daily_costs.is_together = 0');

        $this->data['costs'] = DB::table('daily_costs')
                                    ->whereRaw($condition)
                                    ->join('users','daily_costs.payer','=','users.id')
                                    ->select('daily_costs.*','users.name')
                                    ->get();

        return view('pages.admin.daily_cost_view')->with($this->data);
    }

    public function getMonthlyCostView($month = 6, $year = 2020) {
        $this->data['costs'] = DB::table('daily_costs')
                                    ->whereRaw(DB::raw('MONTH(date) = '.
                                    $month.' and YEAR(date) = '.
                                    $year.' and payer = '.Auth::user()->id.
                                    ' and deleted_at is null and daily_costs.is_together = 0'))
                                    ->join('users','daily_costs.payer','=','users.id')
                                    ->select('daily_costs.*','users.name')
                                    ->get();
        $this->data['costs'] = $this->data['costs']->groupBy('date');
        $this->data['costs']->toJson();
        $this->data['categories'] = Category::all();
        $this->data['month'] = $month;
        $this->data['year'] = $year;
        $this->data['together'] = config('constants.COST_TYPE.PERSONAL');
        $this->data['users'] = User::all();

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

        if ($re->keyword) {
            $condition .= DB::raw(" and daily_costs.payfor like '%$re->keyword%'");
        }

        if ($re->category) {
            $condition .= DB::raw(" and daily_costs.category = $re->category");
        }

        $this->data['costs'] = DB::table('daily_costs')
                                    ->whereRaw($condition)
                                    ->join('users','daily_costs.payer','=','users.id')
                                    ->select('daily_costs.*','users.name')
                                    ->get();

        $this->data['costs'] = $this->data['costs']->groupBy('date');
        $this->data['costs']->toJson();
        $this->data['categories'] = Category::all();
        $this->data['month'] = $re->month;
        $this->data['year'] = $re->year;
        $this->data['together'] = $re->together;

        $re->flash();
        return view('pages.admin.monthly_cost_view')->with($this->data);
    }

    public function filterDailyCost(Request $re) {

        $condition = DB::raw('MONTH(date) = '.$re->month.' and YEAR(date) = '.$re->year.' and deleted_at is null and daily_costs.is_together = 1');

        if ($re->together == config('constants.COST_TYPE.PERSONAL')) {
            $condition = DB::raw('MONTH(date) = '.$re->month.' and YEAR(date) = '.$re->year.' and deleted_at is null and daily_costs.is_together = 0 and daily_costs.payer = '.Auth::user()->id);
        }

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

    public function sendMail($month, $id) {
        try {

        $costs = DB::table('daily_costs')
        ->whereRaw(DB::raw('MONTH(date) = '.$month.' and YEAR(date) = '.date('Y').' and deleted_at is null and daily_costs.is_together = 1'))
        ->join('users','daily_costs.payer','=','users.id')
        ->selectRaw('sum(daily_costs.total / 2) AS total_per_two')
        ->get();

        $ele_cost = DB::table('daily_costs')
        ->whereRaw(DB::raw('MONTH(date) = '.$month.' and YEAR(date) = '.date('Y').' and deleted_at is null and daily_costs.is_together = 1'))
        ->select(['total','payfor'])->where('daily_costs.payfor','like','%tiền điện%')->get();

        $data = array(
            'total' => $costs[0]->total_per_two,
            'ele_cost_name' => $ele_cost[0]->payfor,
            'ele_cost_value' => $ele_cost[0]->total
        );

        Mail::to('kiet1022@gmail.com')->send(new MailNotify($data, 'Dương Tuấn Kiệt'));
        Mail::to('hoangthach1399@gmail.com')->send(new MailNotify($data, 'Trần Hoàng Thạch')); 

        // update notify status
        $managers = StorageManager::find($id);
        $managers->notify_status = 1;
        $managers->save();

        return redirect()->back()->with('success','Gửi mail thành công!');
        } catch (Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());
        }
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

    public function CheckOutInstallment($id, $detail) {
        try {
            DB::beginTransaction();
            $details = InstallmentDetail::find($detail);
            $details->status = 1;


            $installment = Installment::find($id);
            if ($installment->waiting_amout != 0) {
                $installment->waiting_amout = $installment->waiting_amout - $details->trans_amout;
            } else {
                $installment->waiting_amout = $installment->trans_amout - $details->trans_amout;
            }

            $installment->save();
            $details->save();

            $daily = new DailyCost;
            $daily->payfor = "Trả góp $installment->details";
            $daily->payer = Auth::user()->id;
            $daily->date = $details->pay_date;
            $daily->total = $details->trans_amout;
            $daily->is_together = 0;

            if (Auth::user()->id == 1) {
                $daily->percent = "100,0";
            } else {
                $daily->percent = "0,100";
            }
            
            $daily->category = 6;
            $daily->save();

            DB::commit();
            return redirect()->back()->with('success','Cập nhật thành công');
        } catch (Exception $ex) {
            DB::rollback();
            return redirect()->back()->with('error',$ex->getMessage());
        }
    }

    public function AjaxInstallmentDetail(Request $re) {
        $ins_detail = InstallmentDetail::where('installment_id', $re->id)->get();
        return response()->json(['detail'=>$ins_detail]);
    }

    public function statistical($month,$year) {
        $this->data['statis'] = DB::table('daily_costs')
        ->selectRaw(DB::Raw('categories.name, sum(daily_costs.total) as total'))
        ->whereRaw(DB::Raw('MONTH(date) = '.$month.' and YEAR(date) = '.$year.' and payer = '.Auth::user()->id.' and daily_costs.deleted_at is null and daily_costs.is_together = 0'))
        ->join('categories','daily_costs.category','=','categories.id')
        ->groupBy('categories.name')
        ->get();

        $this->data['month'] = $month;
        $this->data['year'] = $year;
        return view('pages.admin.statistical')->with($this->data);
    }

    public function filterStatistical(Request $re) {
        $this->data['statis'] = DB::table('daily_costs')
        ->selectRaw(DB::Raw('categories.name, sum(daily_costs.total) as total'))
        ->whereRaw(DB::Raw('MONTH(date) = '.$re->month.' and YEAR(date) = '.$re->year.' and payer = '.Auth::user()->id.' and daily_costs.deleted_at is null and daily_costs.is_together = 0'))
        ->join('categories','daily_costs.category','=','categories.id')
        ->groupBy('categories.name')
        ->get();

        $this->data['month'] = $re->month;
        $this->data['year'] = $re->year;
        return view('pages.admin.statistical')->with($this->data);
    }

    public function statisticalCompare(){
        $this->data = $this->getStatisCompare(date('Y'), 1, date('m'));
        return view('pages.admin.statistical-compare')->with($this->data);
    }

    public function filterCompareStatistical(Request $re) {
        $this->data = $this->getStatisCompare($re->year, $re->month_from, $re->month_to);
        return view('pages.admin.statistical-compare')->with($this->data);
    }

    private function getStatisCompare($year, $month_from, $month_to) {
        $arr_data = [];
        for($i = $month_from; $i <= $month_to; $i++) {
            $statis = DB::table('daily_costs')
            ->selectRaw(DB::Raw('categories.name, sum(daily_costs.total) as total'))
            ->whereRaw(DB::Raw('MONTH(date) = '.$i.' and YEAR(date) = '.$year.' and payer = '.Auth::user()->id.' and daily_costs.deleted_at is null and daily_costs.is_together = 0'))
            ->join('categories','daily_costs.category','=','categories.id')
            ->groupBy('categories.name')
            ->get();
            // $statis['month'] = $i;

            array_push($arr_data, $statis);
        }
        $this->data['year'] = $year;
        $this->data['month_from'] = $month_from;
        $this->data['month_to'] = $month_to;
        $this->data['arr_data'] = $arr_data;
        return $this->data;
    }

    public function NoftifyAndStorageManagement(){
        $this->data['managers'] = StorageManager::where('year',date('Y'))->orderBy('month','asc')->get();
        return view('pages.admin.notify_storage_manager')->with($this->data);
    }

    public function CleanStorage($id) {
        try {
            DB::beginTransaction();
            $storage = StorageManager::find($id);
            $storage->storage_status = 1;
            $storage->save();
            $images = DB::table('daily_costs')
            ->whereRaw(DB::raw('MONTH(date) = '.$storage->month.' and YEAR(date) = '.date('Y').' and deleted_at is null and daily_costs.is_together = 1'))
            ->get();

            $length = count($images);
            $count = 0;
            for($i=0; $i<$length; $i++) {
                if($images[$i]->image != null) {
                    $path = "img/".$images[$i]->image;
                    if(file_exists($path)){
                        unlink($path);
                        $count++;
                        $old = DailyCost::find($images[$i]->id);
                        $old->image = "removed";
                        $old->save();
                    }
                }
            }
            DB::commit();
            return redirect()->back()->with('success','Đã xoá '.$count.' hoá đơn!');
        } catch (Exception $ex) {
            DB::rollback();
            return redirect()->back()->with('error',$ex->getMessage());
        }

    }

    public function getBalanceList(){
        $this->data['balances'] = Balance::all();
        return view('pages.admin.balance_view')->with($this->data);
    }

    public function addBalance(BalanceRequest $re){
        try {
            DB::beginTransaction();
            $balance = new Balance();
            $balance->month = $re->month;
            $balance->year = date('Y');
            $balance->opening_balance = $re->opening_balance;
            $balance->ending_balance = $re->opening_balance;
            $balance->total_used = 0;
            $balance->save();
            DB::commit();
            return redirect()->back()->with('success','Thêm thành công!');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error','Thêm thất bại!');
        }
    }

    public function getCostCalculation() {
        if(session()->has('data')) {
            session()->forget('data');
        }
        
        return view('pages.admin.cost_caculator');
    }

    public function calculateCost(Request $re) {
        $arr_name = explode(', ',$re->name);
        return redirect()->back()->with('data',array($re->all(), $arr_name));
    }
}
