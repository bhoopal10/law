<?php
class SmsCount extends Eloquent
{
	public static $table='sms_count';
	public function setting()
	{
		return $this->has_one('UserSettings','ui');
	}
}