<?php 
class libsms extends Eloquent
{
	public static function getcount($uid)
	{
		$res=DB::table('sms_count')
			->where('id','=',$uid)
			->first();
		if($res)
		{
			return $res->count;
		}
		else
		{
			return 0;
		}
	}
}