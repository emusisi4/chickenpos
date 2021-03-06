<?php

namespace App\Http\Controllers\API;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\User;
use App\Mainmenucomponent;
use App\Submheader;
use App\Expense;
use App\Expensescategory;
use App\Madeexpense;
use App\Couttransfer;
use App\Cintransfer;
use App\Branchtobalance;
class Incomereportscredits extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
      // $this->middleware('auth:api');
      //  $this->authorize('isAdmin'); 
    }

    public function index()
    {
      $userid =  auth('api')->user()->id;
     $userbranch =  auth('api')->user()->branch;
    $userrole =  auth('api')->user()->type;
     //   if($userrole = 1)
     $user_id = DB::table('branchtobalances')->where('ucret', $userid)->pluck('ucret');
    // $branchto  = Branchtobalance::latest('id')->where('ucret', $userid)->orderBy('id', 'Desc')->limit(1)->value('branchnametobalance');
     
    
    
    
    $startdat = DB::table('incomereporttoviews')->where('ucret', $userid)->value('startdate');
    $enddate = DB::table('incomereporttoviews')->where('ucret', $userid)->value('enddate');
    $branchto = DB::table('incomereporttoviews')->where('ucret', $userid)->value('branch');
  
    
    
    
    
    
    
    
    if($branchto != '900')
   { 
    return    Couttransfer::with(['branchName'])
     ->orderBy('transferdate', 'Asc')
    // ->groupby('id','transferdate','branchto','branchfrom','ucret')
   // ->distinct('branch')
   ->whereBetween('transferdate', [$startdat, $enddate])
     ->where('branchto', $branchto)
    
     ->paginate(100);
   }
   if($branchto = '900')
   { 
    //Madeexpense::with(['branchName','expenseName'])->latest('id')
    return   Couttransfer::with(['branchName'])
     ->orderBy('transferdate', 'Asc')
    // ->groupby('id','transferdate','branchto','branchfrom','ucret')
   // ->distinct('branch')
    // ->where('ucret', $user_id)
    ->whereBetween('transferdate', [$startdat, $enddate])
     ->paginate(100);
   }
    // $totalcashout = \DB::table('cintransfers')
   
     //->where('branchto', '=', $branchto)
    // ->where('transferdate', '=', $dateinquestion)
    // ->where('status', '=', 1)
     //->orderByDesc('id')
     //->limit(1)
     //->get();
     //return $totalcashout;
    










     
     //    ->get();
    // ->join('contacts', 'users.id', '=', 'contacts.user_id')
    // ->join('orders', 'users.id', '=', 'orders.user_id')
    // ->select('users.*', 'contacts.phone', 'orders.price')
   
 //return   DB::table('expensescategories')
    // ->join('Departments', 'Employees.Department', '=', 'Departments.ID')
    // ->select('Employees.Firstname', 'Employees.Surname', 'Employees.Age', 'Departments.Name')
   //  ->get();


       // return Student::all();
     //  return   Submheader::with(['maincomponentSubmenus'])->latest('id')
       // return   MainmenuList::latest('id')
     //    ->where('del', 0)
         //->paginate(15)
     //    ->get();

    // if($userrole == '101')
      {
      
    //     return   Madeexpense::with(['branchName','expenseName'])->latest('id')
      // return   Madeexpense::latest('id')
    //    ->where('del', 0)
    //    ->where('branch', $userbranch)
    //    ->where('explevel', 1)
    //   ->paginate(13);
      }
    //  if($userrole != '101')
      {
      
     //    return   Madeexpense::with(['branchName','expenseName'])->latest('id')
      // return   Madeexpense::latest('id')
     //   ->where('del', 0)
       // ->where('branch', $userbranch)
     //  ->paginate(13);
      }

       //  return Submheader::latest()
         //  -> where('ucret', $userid)
           

       return   Madeexpense::get()->count();








       // {
      // return Submheader::latest()
      //  -> where('ucret', $userid)
    //    ->paginate(15);
      //  }

      
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
       // return ['message' => 'i have data'];



       $this->validate($request,[
        'expense'   => 'required | String |max:191',
        'description'   => 'required',
        'amount'  => 'required',
        'datemade'  => 'required',
        'branch'  => 'required',
       // 'expensetype'   => 'sometimes |min:0'
     ]);


     $userid =  auth('api')->user()->id;
     //$id1  = Expense::latest('id')->where('del', 0)->orderBy('id', 'Desc')->limit(1)->value('expenseno');
     //$hid = $id1+1;

  
     
  //       $dats = $id;
       return Madeexpense::Create([
      'expense' => $request['expense'],
     //'expenseno' => $hid,
      'description' => $request['description'],
      'amount' => $request['amount'],
      'datemade' => $request['datemade'],
      'branch' => $request['branch'],
 
      'ucret' => $userid,
    
  ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
   
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $user = Madeexpense::findOrfail($id);

$this->validate($request,[
    'expense'   => 'required | String |max:191',
    'description'   => 'required',
    'amount'  => 'required',
    'datemade'  => 'required',
    'branch'  => 'required'
]);

 
     
$user->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
     //   $this->authorize('isAdmin'); 

        $user = Madeexpense::findOrFail($id);
        $user->delete();
       // return['message' => 'user deleted'];

    }
}
