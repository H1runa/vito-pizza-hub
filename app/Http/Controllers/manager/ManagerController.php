<?php

namespace App\Http\Controllers\manager;

use App\Http\Controllers\Controller;
use App\Models\CusOrderReturn;
use App\Models\CusOrderReturn_CustomerOrder;
use App\Models\CusOrderReturn_MenuItem;
use App\Models\Customer;
use App\Models\CustomerOffer;
use App\Models\CustomerOrder_MenuItem;
use App\Models\ExtraTopping;
use App\Models\Feedback;
use App\Models\MenuItem;
use App\Models\CustomerOrder;
use App\Models\ServiceChargeAllowance;
use App\Models\Staff;
use App\Models\StaffAttendance;
use App\Models\StaffLeave;
use App\Models\StaffOvertimeAllowance;
use App\Models\SystemUser;
use App\Models\Salary;
use App\Models\EPF;
use App\Models\ETF;
use Illuminate\Http\Request;

class ManagerController extends Controller
{
    public function dashboard(){
        $att = StaffAttendance::all();
        $data = [];
        foreach ($att as $a){
            $staff = Staff::find($a->staffID);

            $temp = [
                'staff' => $staff,
                'attendance' => $a
            ];

            array_push($data, $temp);
        }

        return view('manager.attendance', compact('data'));
    }

    public function menu(){
        $items = MenuItem::all();

        return view('manager.menu-items', compact('items'));
    }

    public function toppings(){
        $toppings = ExtraTopping::all();

        return view('manager.toppings', compact('toppings'));
    }

    public function offers(){
        $offers = CustomerOffer::all();

        return view('manager.offers', compact('offers'));
    }

    public function returns(){
        $data = [];
        try{
            $returns = CusOrderReturn::all();
            foreach ($returns as $re){
                $temp_order = CusOrderReturn_CustomerOrder::where('cusRetID', $re->cusRetID)->get();
                $items = CusOrderReturn_MenuItem::where('cusRetID', $re->cusRetID)->get();
                //getting the actual values
                $menuitems = [];
                foreach ($items as $it){
                    $i = MenuItem::find($it->menuID);
                    array_push($menuitems, $i);
                }
                // dd($temp_order);
                $order = CustomerOrder::find(intval($temp_order->first()->orderID));
                // dd($order);
                
                $array = [
                    'return' => $re,
                    'order' => $order,
                    'menuItems' => $menuitems
                ];   
                
                array_push($data, $array);
               
            }
        } catch(\Exception $e){
            return redirect()->back()->with('error', 'Return data could not be retrieved');
        }

        // dd($data);

        return view('manager.returns', compact('data'));
    }

    public function add_return(Request $request){
        $request->validate([
            'orderID' => 'required|integer',
            'returnDate' => 'required|date',
            'reason' => 'required|string|max:500',
            'actionTaken' => 'required|string|max:500',
        ]);

        try{
            //retrieving necessary data
            $order = CustomerOrder::find($request->orderID);            
            $menuitems = CustomerOrder_MenuItem::where('orderID', $request->orderID)->get();

            //saving the data
            $return = CusOrderReturn::create([
                'orderReturn_Date' => $request->returnDate,
                'reason' => $request->reason,
                'actionTaken' => $request->actionTaken
            ]);

            CusOrderReturn_CustomerOrder::create([
                'orderID' => $request->orderID,
                'cusRetID' => $return->cusRetID,
                'quantity' => 1
            ]);
            foreach ($menuitems as $item){
                CusOrderReturn_MenuItem::create([
                    'cusRetID' => $return->cusRetID,
                    'menuID' => $item->menuID
                ]);
            }

            return redirect()->back()->with('success', 'Customer Return added successfully');
            
        } catch (\Exception $e){
            return redirect()->back()->with('error', 'Failed to add Customer Return');
        }
    }

    public function delete_return($id){
        try{
            $return = CusOrderReturn::find($id);
            //deleting menuitems with the retID
            $items = CusOrderReturn_MenuItem::where('cusRetID', $id)->get();
            foreach($items as $item){
                $item->delete();
            }
            //deleting cusorder_return
            $return_order = CusOrderReturn_CustomerOrder::where('cusRetID', $id)->get();
            foreach($return_order as $ret){
                $ret->delete();
            }
            

            //deleting the return
            $return->delete();

            return redirect()->back()->with('success', 'Return deleted successfully');
        } catch (\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function order_history(){
        $customers = Customer::all();

        return view('manager.order-history', compact('customers'));
    }

    public function view_order_history($id){
        try{
            $orders = CustomerOrder::where('cusID', $id)->get();        
            
            return view('manager.customer-history', compact('orders'));
        } catch(\Exception $e){
            return redirect()->back()->with('error', 'Customer order history could not be retrieved');
        }        
        
    }

    public function feedback(){
        try{
            $feed = [];
            $feedbacks = Feedback::all();
            foreach ($feedbacks as $f){
                $cus = Customer::find($f->cusID);
                $staff = Staff::find($f->staffID);

                $temp = [
                    'feedback' => $f,
                    'customer' => $cus,
                    'staff' => $staff
                ];

                array_push($feed, $temp);
            }
            // dd($feed);
            return view('manager.view-feedback', compact('feed'));
        } catch(\Exception $e){
            return redirect()->back()->with('error', 'Could not retrieve feedback data');
        }
    }

    public function staff(){
        try{
            $staff = Staff::all();

            return view('manager.view-staff', compact('staff'));
        } catch(\Exception $e){
            return redirect()->back()->with('Error', 'Staff Members could not be retrieved');
        }
        
    }
    
    public function sysusers(){
        try{
            $sysusers = [];
            $users = SystemUser::all();
            foreach($users as $u){
                $staff = Staff::find($u->staffID);

                $tmp = [
                    'staff' => $staff,
                    'user' => $u
                ];

                array_push($sysusers, $tmp);
            }

            $noLogin = Staff::whereNotIn('staffID', SystemUser::pluck('staffID'))->get();            

            // dd($sysusers);
            return view('manager.view-systemuser', compact('sysusers', 'noLogin'));
        } catch(\Exception $e){
            return redirect()->back()->with('error', 'Could not retieve system users list');
        }
    }

    public function salary(){
        $salary = Salary::all();
        $salaries = [];

        foreach($salary as $s){
            $staff = Staff::find($s->staffID);

            $tmp = [
                'staff' => $staff,
                'salary' => $s
            ];

            array_push($salaries, $tmp);
        }
        
        return view('manager.salary', compact('salaries'));
    }

    public function EPF(){
        try{
            $epf = EPF::all();

            $data = [];

            foreach($epf as $e){
                $staff = Staff::find($e->staffID);

                $tmp = [
                    'staff' => $staff,
                    'epf' => $e
                ];

                array_push($data, $tmp);
            }

            return view('manager.epf', compact('data'));
        } catch(\Exception $e){
            return redirect()->back()->with('error', 'EPF data not loaded.');
        }
    }

    public function ETF(){
        try{
            $etf = ETF::all();

            $data = [];

            foreach($etf as $e){
                $staff = Staff::find($e->staffID);

                $tmp = [
                    'staff' => $staff,
                    'etf' => $e
                ];

                array_push($data, $tmp);
            }

            return view('manager.etf', compact('data'));
        } catch(\Exception $e){
            return redirect()->back()->with('error', 'ETF data not loaded.');
        }
    }

    public function leaves(){
        $leaves = StaffLeave::all();
        $data = [];

        foreach($leaves as $leave){
            $staff = Staff::find($leave->staffID);

            $temp = [
                'staff' => $staff,
                'leave' => $leave 
            ];

            array_push($data, $temp);
        }

        return view('manager.leaves', compact('data'));
    }

    public function attendance(){
        $att = StaffAttendance::all();
        $data = [];
        foreach ($att as $a){
            $staff = Staff::find($a->staffID);

            $temp = [
                'staff' => $staff,
                'attendance' => $a
            ];

            array_push($data, $temp);
        }

        return view('manager.attendance', compact('data'));
    }

    public function serv(){
        $servs = ServiceChargeAllowance::all();

        return view('manager.serv', compact('servs'));
    }

    public function overtime(){
        $ot = StaffOvertimeAllowance::all();
        $data = [];

        foreach($ot as $o){
            $staff = Staff::find($o->staffID);

            $temp = [
                'staff' => $staff,
                'ot' => $o
            ];
            array_push($data, $temp);
        }
        return view('manager.overtime', compact('data'));
    }
}
