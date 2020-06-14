<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailNotify;

/* Model Import */
Use App\Model\User;
Use App\Model\FixedCost;
Use App\Model\DailyCost;

class AdminController extends Controller
{
    public function getFixedCostView() {
        $this->data['costs'] = FixedCost::all();
        return view('pages.admin.fixed_cost_view')->with($this->data);
    }

    public function getDailyCostView() {
        $this->data['month'] = date('m');
        $this->data['year'] = date('Y');
        $this->data['costs'] = DB::table('daily_costs')
                                    ->whereRaw(DB::raw('MONTH(date) = '.$this->data['month'].' and YEAR(date) = '.$this->data['year'].' and deleted_at is null'))
                                    ->where('payer', Auth::user()->id)
                                    ->join('users','daily_costs.payer','=','users.id')
                                    ->select('daily_costs.*','users.name')
                                    ->get();
        return view('pages.admin.daily_cost_view')->with($this->data);
    }

    public function getAddDailyCostView() {
        $this->data['users'] = User::all();
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
            DB::commit();
            return redirect()->back()->with('success','Thêm thành công!');
        } catch (Exception $ex) {
            DB::rollback();
            return redirect()->back()->with('error','Thêm Thất bại!');
        }
    }

    public function getEditDailyCostView($id) {
        $this->data['oldCost'] = DailyCost::find($id);
        $this->data['users'] = User::all();
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

    public function getMonthlyCostView($month, $year) {
        $this->data['costs'] = DB::table('daily_costs')
                                    ->whereRaw(DB::raw('MONTH(date) = '.$month.' and YEAR(date) = '.$year.' and deleted_at is null'))
                                    ->join('users','daily_costs.payer','=','users.id')
                                    ->select('daily_costs.*','users.name')
                                    ->get();
        $this->data['month'] = $month;
        $this->data['year'] = $year;
        $this->data['payer'] = 0;
        $this->data['users'] = User::all();
        // return $this->data;
        return view('pages.admin.monthly_cost_view')->with($this->data);
    }

    public function filterMonthlyCost(Request $re) {
        if ($re->payer != 0) {
            $condition = DB::raw('MONTH(date) = '.$re->month.' and YEAR(date) = '.$re->year.' and deleted_at is null and daily_costs.payer = '.$re->payer);
        } else {
            $condition = DB::raw('MONTH(date) = '.$re->month.' and YEAR(date) = '.$re->year.' and deleted_at is null');
        }
        $this->data['costs'] = DB::table('daily_costs')
                                    ->whereRaw($condition)
                                    ->join('users','daily_costs.payer','=','users.id')
                                    ->select('daily_costs.*','users.name')
                                    ->get();
        $this->data['month'] = $re->month;
        $this->data['year'] = $re->year;
        $this->data['payer'] = $re->payer;
        $this->data['users'] = User::all();
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
}
