<?php 
class Admin_Selectlist_Controller extends Admin_Base_Controller
{
	public $restful=true;
	public function get_selectList($id)
	{
		$clients=DB::table('client')
			->where('update_by','=',$id)
			->get(array('client_id','client_name'));
		$lawyers=DB::table('users')
		->where('updated_by','=',$id)
		->get(array('id','first_name'));
		$case=DB::table('case')
		->where('lawyer_id','=',$id)
		->get(array('case_id','case_no'));
		$tot=array('cases'=>$case,
					'client'=>$clients,
					'lawyer'=>$lawyers);

		echo json_encode($tot);
	}
}