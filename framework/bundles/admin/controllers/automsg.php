<?php

    class Admin_Automsg_Controller extends Admin_Base_Controller {
        public $restful=true;

        public function get_sendMessage()
        {
            $hearing=DB::query("SELECT *
                                FROM `hearing`
                                WHERE `next_hearing_date` = DATE_ADD( CURDATE( ) , INTERVAL 1 DAY )");


           if($hearing)
            {
                foreach($hearing as $hearings)
                {
                    $case=Cases::getCaseDetailsByID($hearings->case_id);
                    if($case)
                    {
                        $lawyer=DB::query("SELECT first_name,last_name,username,user_email,mobile,address from users where id= ?",array($case->lawyer_id));
                        $client=DB::query("SELECT client_name,mobile,email from client where client_id =?",array($case->client_id));
                        $check=SmsCount::find($hearings->lawyer_id);
                          if(!$check)
                          {
                              $check=SmsCount::create(array('id'=>$hearings->lawyer_id,'count'=>'0'));
                          }
                        if($lawyer)
                        {
                            if($lawyer[0]->mobile)
                            {

                              /*Condition for SMS permission*/
                            
                              if($check->setting->sms_permission && $check->count <= $check->setting->no_sms)
                              {
                                  $mob=explode(',',$lawyer[0]->mobile);
                                 $mobile='';
                                 if($mob){foreach($mob as $num){
                                      $mobile.=($mobile)?',91'.$num:'91'.$num;
                                 }}
                                 $case_no=$case->case_no;
                                 $client_name=($client)?$client[0]->client_name:'';
                                 $hearing_date=$hearings->next_hearing_date;
                                 $lawyer_name=$lawyer[0]->first_name.''.$lawyer[0]->last_name;
                                 $hearing_date=implode('/',array_reverse(explode('-',$hearing_date)));
                                 $data="Client: $client_name\ncaseNo: $case_no\nhDate:$hearing_date\nDesc:$hearings->action_plan";
                                 $count=strlen($data);
                                 if($count > 159 )
                                 {
                                  $data=substr($data,0,159);
                                 }
                                 $data=urlencode($data);
                                 
                                 $url = "http://bulksms.mysmsmantra.com/WebSMS/SMSAPI.jsp?username=sirigroup&password=India123&sendername=netsms&mobileno=$mobile&message=$data";
                                $ch = curl_init($url);
                                 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                $res = curl_exec($ch);
                                echo curl_error($ch);
                                curl_close($ch);
                                if($res)
                                {
                                  $check->count=$check->count+1;
                                  $check->save();

                                }
                              }
                               
                            }
                            $body=View::make('admin::lawyer/template.hearing_message')
                                ->with('lawyer',$lawyer[0])
                                ->with('client',($client) ? $client[0] : '')
                                ->with('hearing',$hearings);
                            $mail = new PHPMailer();
                            $mail->isSMTP(); 
                            $mail->Host = 'p3plcpnl0274.prod.phx3.secureserver.net';
                            $mail->Port='465';
                            $mail->Username = 'admin@lawyerzz.in';                 // SMTP username
                            $mail->Password = 'Zodiac@2014';                           // SMTP password
                            $mail->SMTPSecure = 'ssl';  
                            $mail->setFrom('admin@lawyerzz.in',$lawyer[0]->first_name.''.$lawyer[0]->last_name);
                            $mail->addReplyTo($lawyer[0]->user_email,$lawyer[0]->first_name.''.$lawyer[0]->last_name);
                            // $mail->addAddress('bhoopal10@gmail.com',$lawyer[0]->first_name);

                           $mail->addAddress($lawyer[0]->user_email,$lawyer[0]->first_name);
                            $lMail=explode(',',$lawyer[0]->email);
                            if($lMail){foreach($lMail as $cliMail){
                                $mail->addAddress($cliMail,$lawyer[0]->first_name.''.$lawyer[0]->last_name);
                            }}
                            $mail->Subject =($client)? $client[0]->client_name.'Hearings':'Hearings';
                            $mail->Body=$body;
                            if (!$mail->send()) {
                                echo $mail->ErrorInfo;
                                print_r($client);
                                print_r($lawyer);
                                echo "<hr>";
                            }
                        }
                        if($client)
                        {
                            if($client[0])
                            {
                              /*Condition for SMS permission*/
                            
                                if($check->setting->sms_permission && $check->count <= $check->setting->no_sms)
                                {
                                    $mob=explode(',',$client[0]->mobile);
                                    $mobile='';
                                    if($mob){foreach($mob as $num)
                                      {
                                        $mobile.=($mobile)?',91'.$num:'91'.$num;
                                     }}
                                    $case_no=$case->case_no;
                                    $client_name=$client[0]->client_name;
                                    $hearing_date=$hearings->next_hearing_date;
                                    $lawyer_name=($lawyer)? $lawyer[0]->first_name.''.$lawyer[0]->last_name : "";
                                   $hearing_date=implode('/',array_reverse(explode('-',$hearing_date)));
                                   $data="Lawyer: $lawyer_name\ncaseNo: $case_no\nhDate:$hearing_date\nDesc:$hearings->action_plan";
                                   $count=strlen($data);
                                   if($count > 159 )
                                   {
                                    $data=substr($data,0,159);
                                   }
                                   $data=urlencode($data);
                                   
                                   $url = "http://bulksms.mysmsmantra.com/WebSMS/SMSAPI.jsp?username=sirigroup&password=India123&sendername=netsms&mobileno=$mobile&message=$data";
                                   $ch = curl_init($url);
                                   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                   $curl_scraped_page = curl_exec($ch);
                                   echo curl_error($ch);
                                   curl_close($ch);
                                  if($res)
                                  {
                                    $check->count=$check->count+1;
                                    $check->save();
                                  }
                              }
                               
                            }
                            $body=View::make('admin::lawyer/template.hearing_message')
                                ->with('lawyer',($lawyer)?$lawyer[0]:'')
                                ->with('client',$client[0])
                                ->with('hearing',$hearings);
                            $mail = new PHPMailer();
                            $mail->isSMTP(); 
                            $mail->Host = 'p3plcpnl0274.prod.phx3.secureserver.net';
                            $mail->Port='465';
                            $mail->Username = 'admin@lawyerzz.in';                 // SMTP username
                            $mail->Password = 'Zodiac@2014';                           // SMTP password
                            $mail->SMTPSecure = 'ssl';
                            $mail->setFrom('admin@lawyerzz.in',($lawyer)?$lawyer[0]->first_name.''.$lawyer[0]->last_name:'lawyer');
                            $mail->addReplyTo(($lawyer)?$lawyer[0]->user_email:'lawyer@gmail.com',($lawyer)?$lawyer[0]->first_name.''.$lawyer[0]->last_name:'lawyer');
                            // $mail->addAddress('bhoopal10@gmail.com',$client[0]->client_name);
                            $cMail=explode(',',$client[0]->email);
                            if($cMail){foreach($cMail as $cliMail){
                              $mail->addAddress($cliMail,$client[0]->client_name);
                            }}
                           
                            $mail->Subject = $client[0]->client_name.'Hearings';
                            $mail->Body=$body;
                            if (!$mail->send()) {
                                echo $mail->ErrorInfo;
                                print_r($client);
                                print_r($lawyer);
                                echo "<hr>";
                            }

                        }

                    }
                }
            }
            return Redirect::to('http://lawyerzz.in/law/admin/backup-please/go');
        }
        public function sendSms($data)
        {
            return View::make('home.test')->with('data',$data);
//            echo 'hh';
        }

    }
   