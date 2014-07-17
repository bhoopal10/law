<?php
class libpayment extends Eloquent
{
	public static $table='payment'	;
	/*
	By lawyerID fetch client ditails
	*/
	public static function  getClientByLawyerId($id)
	{
		$data=DB::query("select c.client_name,c.client_id from payment p, client c where c.client_id=p.to_user and from_user=$id group by c.client_id order by c.client_name");
		return $data;
	}
}