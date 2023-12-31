<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SchoolSubject;
use App\Models\StudentClass; 
use App\Models\AssignSubject;

class AssignSubjectController extends Controller
{
    public function AssignSubjectView(){
$data['allData'] = AssignSubject::select('class_id')->groupBy('class_id')->get();
return view('admin.assign_subject.view_assign_subject',$data);
    }

    public function AssignSubjectAdd(){
    	$data['subjects'] = SchoolSubject::all();
    	$data['classes'] = StudentClass::all();
    	return view('admin.assign_subject.add_assign_subject',$data);
    }


	public function AssignSubjectStore(Request $request){

	    	$subjectCount = count($request->subject_id);
	    	if ($subjectCount !=NULL) {
	    		for ($i=0; $i <$subjectCount ; $i++) { 
	    			$assign_subject = new AssignSubject();
	    			$assign_subject->class_id = $request->class_id;
	    			$assign_subject->subject_id = $request->subject_id[$i];
	    			$assign_subject->full_mark = $request->full_mark[$i];
	    			$assign_subject->pass_mark = $request->pass_mark[$i];
	    			$assign_subject->save();

	    		} // End For Loop
	    	}// End If Condition

	    	$notification = array(
	    		'message' => 'Subject Assign Inserted Successfully',
	    		'alert-type' => 'success'
	    	);

	    	return redirect()->route('assign.subject.view')->with($notification);

	    }  // End Method 


	 public function AssignSubjectEdit($class_id){
	    	$data['editData'] = AssignSubject::where('class_id',$class_id)->orderBy('subject_id','asc')->get();
	    $data['subjects'] = SchoolSubject::all();
    	$data['classes'] = StudentClass::all();
    	return view('admin.assign_subject.edit_assign_subject',$data);

	    }


public function AssignSubjectUpdate(Request $request,$class_id){
    	if ($request->subject_id == NULL) {
       
        $notification = array(
    		'message' => 'Sorry You do not select any Subject',
    		'alert-type' => 'error'
    	);

    	return redirect()->route('assign.subject.edit',$class_id)->with($notification);
    		 
    	}else{
    		 
    $countClass = count($request->subject_id);
	AssignSubject::where('class_id',$class_id)->delete(); 
    		for ($i=0; $i <$countClass ; $i++) { 
    			$assign_subject = new AssignSubject();
	    			$assign_subject->class_id = $request->class_id;
	    			$assign_subject->subject_id = $request->subject_id[$i];
	    			$assign_subject->full_mark = $request->full_mark[$i];
	    			$assign_subject->pass_mark = $request->pass_mark[$i];
	    			$assign_subject->save();

    		} // End For Loop	 

    	}// end Else

       $notification = array(
    		'message' => 'Data Updated Successfully',
    		'alert-type' => 'success'
    	);

    	return redirect()->route('assign.subject.view')->with($notification);
    } // end Method 


	public function DetailsAssignSubject($class_id){
   $data['detailsData'] = AssignSubject::where('class_id',$class_id)->orderBy('subject_id','asc')->get();

   return view('admin.assign_subject.detail_assign_subject',$data);


 	}

}
