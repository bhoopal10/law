<?php
/**
 * Created by PhpStorm.
 * User: bhoo
 * Date: 1/24/14
 * Time: 5:53 PM
 */

class Admin_payment_Controller extends Admin_Base_Controller
{
    public $restful=true;
    public function get_CreateInvoice()
    {
        return View::make('admin::lawyer/invoice.create_invoice');
    }
    public function get_ViewInvoice()
    {
        $uid=Auth::user()->id;
        if($_GET && array_filter(Input::all()))
        {

            Input::flash();
            $client_id=Input::get('client_id','0');
            $from=Input::get('from_date','01/01/1970');
            $from=($from) ? implode('-',array_reverse(explode('/',$from))):'1970-01-01';
            $to=Input::get('to_date','01/01/4015');
            $to=($to) ? implode('-',array_reverse(explode('/',$to))).' 23:59:59':'4015-01-01';
            if(!$client_id)
            {
                 if($from == $to)
                {
                    $data= DB::query("select * from payment where created_date LIKE ? AND payment_id IN(select max(payment_id) from payment where from_user = $uid  group by to_user)",array("%$from%"));
                }
                else
                {
                 $data= DB::query("select * from payment where created_date between ? AND ? AND payment_id IN(select max(payment_id) from payment where  from_user = $uid  group by to_user)",array($from,$to));
                }

            }
            else
            {
                if($from == $to)
                {
                    $data=DB::query("select * from payment where payment_id IN(select max(payment_id) from payment where from_user = $uid AND to_user = $client_id AND created_date LIKE ?  group by to_user)",array("%$from%"));
                }
                else
                {
                    $data=DB::query("select * from payment where payment_id IN(select max(payment_id) from payment where from_user = $uid AND to_user = $client_id AND created_date between ? AND ? group by to_user)",array($from,$to));    
                }
                
                
            }
            $count=count($data);
            $payment=Paginator::make($data,$count,'15');
            return View::make('admin::lawyer/invoice.view_invoice')        
                    ->with('invoice',$payment);
        }
        $payment=Payment::getInvoiceByID($uid);
        $count=count($payment);
        $perpage='15';
        $payment=Paginator::make($payment,$count,$perpage);
        return View::make('admin::lawyer/invoice.view_invoice')
                ->with('invoice',$payment);
    }
   public function get_EditInvoice($id)
   {
       $uid=Auth::user()->id;
       $payment=DB::query('select * from payment where payment_id= ? AND from_user= ?',array($id,$uid));
       if($payment)
       {
           return View::make('admin::lawyer/invoice.edit_invoice')
               ->with('invoice',$payment[0]);
       }
       else{
           return Response::error('404');
       }
   }

    public function get_InvoiceDetail($id)
    {
        $invoice=Payment::getInvoiceDetailByID($id);
        $lawyer = User::getUserAddressByID( $invoice->from_user );
        $client=Client::getClientDetailByID($invoice->to_user);
        $case=Cases::getCaseDetailsByID($invoice->case_id);
        $des=json_decode($invoice->description);
        $total=$des->total;
        unset($des->total);
        return View::make('admin::lawyer/invoice.invoice_details')
            ->with('lawyer',$lawyer)
            ->with('description',$des)
            ->with('case',$case)
            ->with('total',$total)
            ->with('client',$client)
            ->with('invoice',$invoice);
    }

    public function post_SendInvoice ()
    {
        if($id=Input::get('payment_id'))
        {
            $invoice=Payment::getInvoiceDetailByID($id);
            $client=Client::getClientDetailByID($invoice->to_user);
            $case=Cases::getCaseDetailsByID($invoice->case_id);
            $lawyer=User::getUserAddressByID($invoice->from_user);
            $description=json_decode($invoice->description);
            $total=$description->total;
            unset($description->total);
            $payment=array('description'=>(array)$description,'total'=>$total,
                'bill_no'=>$invoice->bill_no,'date'=>$invoice->created_date,
                'discount'=>$invoice->discount,'netTotal'=>$invoice->total,
                'bal'=>$invoice->due_amount,'paid'=>$invoice->paid,'status'=>$invoice->status,
                'due'=>$invoice->old_due,'modified'=>$invoice->modified_date);
            $body=View::make('admin::lawyer/template.client_invoice')
                ->with('case',$case)
                ->with('lawyer',$lawyer)
                ->with('payment',$payment)
                ->with('client',$client);

           
            $mail = new PHPMailer();

            $mail->isSendmail();
            $mail->setFrom($lawyer->user_email,$lawyer->first_name);
            $mail->addReplyTo($lawyer->user_email,$lawyer->first_name);
            $mail->addAddress($client->email,$client->client_name);
            $mail->Subject = 'Invoice';
            $mail->Body=$body;
            if (!$mail->send()) {
                echo $mail->ErrorInfo;
            } else
            {
                echo "Message sent!";
            }

        }
    }
    public function post_UpdatePayment()
    {
        $from_user=Auth::user()->id;
        $date=date('Y-m-d');
        $id=Input::get('payment_id');
        $pay=Input::get('pay',0);
        $due=Input::get('due',0);
        $paid=Input::get('paid',0);
        $to_user=Input::get('to_user',0);
        $description=Input::get('description');
        $status=($pay >= $due)?'1':'0';
        $paid=$pay+$paid;
        $payment_id=$id;
        $due=$due-$pay;
        $Pre=DB::table('payment')
            ->where('payment_id','=',$id)
            ->first();
        $data=(array)$Pre;
        $data['modified_date']=$date;
        $data['paid']=$paid;
        $data['due_amount']=$due;
        $data['status']=$status;
        unset($data['payment_id']);
        $res=Payment::insert($data);
        Payment::where('to_user','=',$to_user)
                ->update(array('status'=>$status));
        return ($res) ? Redirect::back()->with('status','Payment has been updated') : Redirect::back()->status('error','Failed to update payment ');
    }

    public function post_AddInvoice()
    {
        $id=Auth::user()->id;
        $values=Input::all();
        $total=array_sum($values['amount']);
        $description=array();
        $amount=array();
        $lawyer=User::getUserAddressByID($id);

        foreach($values['description'] as $key=>$value)
        {
            if($value!='' && $value!='total') array_push($description,$value);
        }
        foreach($values['amount'] as $key=>$value)
        {
            if($value!='') array_push($amount,$value);
        }
         $arr=array_combine($description,$amount);
        $arr['total']=$total;
        $des=json_encode($arr);
        $from_id=$id;
        $to_id=$values['client_id'];
        $bill_no=$values['bill_no'];
        $case_id=$values['case_id'];
        $due=Input::get('due',0);
        $oldDue=Input::get('due_amount',0);
        $paid=Input::get('paid',0);
        $note=Input::get('note','');
        $netTotal=Input::get('total',0);
        $discount=Input::get('discount',0);
        $date=date('Y-m-d H:i:s');
        $status=($due <= 0)?'1':'0';
        $data=array(
            'from_user'=>$from_id,
            'to_user'=>$to_id,
            'description'=>$des,
            'bill_no'=>$bill_no,
            'case_id'=>$case_id,
            'created_date'=>$date,
            'modified_date'=>$date,
            'total'=>$netTotal,
            'due_amount'=>$due,
            'paid'=>$paid,
            'status'=>$status,
            'discount'=>$discount,
            'note'=>$note,
            'old_due'=>$oldDue
        );

        $res=Payment::insert_get_id($data);
        Payment::where('to_user','=',$to_id)
            ->update(array('status'=>$status));
        if(isset($values['email']))
        {
        /*Payment Detail*/
        $descri=$arr;
        unset($descri['total']);
        $payment=array('description'=>$descri,'total'=>$total,
            'bill_no'=>$bill_no,'date'=>$date,'discount'=>$discount,
            'netTotal'=>$netTotal,'bal'=>$due,'paid'=>$paid,
            'status'=>$status,'due'=>$oldDue,'modified'=>$date);
        /*Client Details*/
        $client=Client::getClientDetailByID($to_id);
        $case=Cases::getCaseDetailsByID($case_id);
        $email_id=$client->email;
        $client_name=$client->client_name;

        $body=View::make('admin::lawyer/template.client_invoice')->with('case',$case)->with('client',$client)->with('lawyer',$lawyer)->with('payment',$payment);
       $mail = new PHPMailer();

        $mail->isSendmail();
//Set who the message is to be sent from
        $mail->setFrom($lawyer->user_email,$lawyer->first_name);
//Set an alternative reply-to address
        $mail->addReplyTo($lawyer->user_email,$lawyer->first_name);
//Set who the message is to be sent to
        // $mail->addAddress('bhoopal10@gmail.com',$client_name);
         $mail->addAddress($email_id,$client_name);
//Set the subject line
        $mail->Subject = 'Invoice';
        $mail->Body=$body;

//send the message, check for errors
        if (!$mail->send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        } else {
            echo "Message sent!";
        }
    }
        return ($res) ? Redirect::to('admin/invoice/invoice-detail/'.$res)->with('status','Invoice created successfully') : Redirect::back()->with('error','Failed to create Invoice');

    }
    public function post_UpdateInvoice()
    {
        $id=Auth::user()->id;
        $values=Input::all();
        $invoice_id=$values['id'];
        $total=array_sum($values['amount']);
        $description=array();
        $amount=array();
        $lawyer=User::getUserAddressByID($id);
        foreach($values['description'] as $key=>$value)
        {
            if($value!='' && $value!='total') array_push($description,$value);
        }
        foreach($values['amount'] as $key=>$value)
        {
            if($value!='') array_push($amount,$value);
        }
        $arr=array_combine($description,$amount);
        $arr['total']=$total;
        $des=json_encode($arr);
        $from_id=$id;
        $to_id=$values['client_id'];
        $bill_no=$values['bill_no'];
        $case_id=$values['case_id'];
        $due=Input::get('due',0);
        $oldDue=Input::get('due_amount',0);
        $paid=Input::get('paid',0);
        $note=Input::get('note','');
        $netTotal=Input::get('total',0);
        $discount=Input::get('discount',0);
        $date=date('Y-m-d H:i:s');
        $status=($due <= 0)?'1':'0';
        $data=array(
            'from_user'=>$from_id,
            'to_user'=>$to_id,
            'description'=>$des,
            'bill_no'=>$bill_no,
            'case_id'=>$case_id,
            'modified_date'=>$date,
             'total'=>$netTotal,
            'due_amount'=>$due,
            'paid'=>$paid,
            'status'=>$status,
            'discount'=>$discount,
            'note'=>$note,
            'old_due'=>$oldDue
        );

        $res=Payment::updateStatus($invoice_id,$data);
        Payment::where('to_user','=',$to_id)
            ->update(array('status'=>$status));
        if(isset($values['email']))
        {
            /*Payment Detail*/
            $descri=$arr;
            unset($descri['total']);
            $payment=array('description'=>$descri,'total'=>$total,'bill_no'=>$bill_no,
                            'date'=>$date,'discount'=>$discount,
                            'netTotal'=>$netTotal,'bal'=>$due,'paid'=>$paid,
                            'status'=>$status,'due'=>$oldDue);
            /*Client Details*/
            $client=Client::getClientDetailByID($to_id);
            $case=Cases::getCaseDetailsByID($case_id);
            $email_id=$client->email;
            $client_name=$client->client_name;

            $body=View::make('admin::lawyer/template.client_invoice')->with('case',$case)->with('client',$client)->with('lawyer',$lawyer)->with('payment',$payment);

            $mail = new PHPMailer();

            $mail->isSendmail();
//Set who the message is to be sent from
            $mail->setFrom($lawyer->user_email,$lawyer->first_name);
//Set an alternative reply-to address
            $mail->addReplyTo($lawyer->user_email,$lawyer->first_name);
//Set who the message is to be sent to
            $mail->addAddress($email_id,$client_name);
//Set the subject line
            $mail->Subject = 'Invoice';
            $mail->Body=$body;

//send the message, check for errors
            if (!$mail->send()) {
                echo "Mailer Error: " . $mail->ErrorInfo;
            } else {
                echo "Message sent!";
            }
        }
        return ($res) ? Redirect::to('admin/invoice/invoice-detail/'.$invoice_id)->with('status','Updated successfully') : Redirect::back()->with('error','Failed to update Invoice');

    }
    public function get_DeleteInvoice ( $id )
    {
        $del=DB::query('delete from payment where payment_id= ?',array($id));
        if($del)
        {
            return Redirect::back()->with('status','Deleted successfully');
        }
    }
    public function get_PaidBill()
    {
        $uid=Auth::user()->id;
         if($_GET && array_filter(Input::all()))
        {
            Input::flash();
            $client_id=Input::get('client_id','0');
            $from=Input::get('from_date','01/01/1970');
            $from=($from) ? implode('-',array_reverse(explode('/',$from))):'1970-01-01';
            $to=Input::get('to_date','01/01/4015');
            $to=($to) ? implode('-',array_reverse(explode('/',$to))).' 23:59:59':'4015-01-01';
            if(!$client_id)
            {
                if($from == $to)
                {
                    $data= DB::query("select * from payment where created_date LIKE ? AND payment_id IN(select max(payment_id) from payment where status = 1 AND from_user = $uid  group by to_user)",array("%$from%"));
                }
                else
                {
                 $data= DB::query("select * from payment where created_date between ? AND ? AND payment_id IN(select max(payment_id) from payment where status = 1 AND from_user = $uid  group by to_user)",array($from,$to));
                }
                
            }
            else
            {
                if($from == $to)
                {
                    $data=DB::query("select * from payment where payment_id IN(select max(payment_id) from payment where status = 1 AND from_user = $uid AND to_user = $client_id AND created_date LIKE ?  group by to_user)",array("%$from%"));
                }
                else
                {
                    $data=DB::query("select * from payment where payment_id IN(select max(payment_id) from payment where status = 1 AND from_user = $uid AND to_user = $client_id AND created_date between ? AND ? group by to_user)",array($from,$to));    
                }
            }
            $count=count($data);
            $payment=Paginator::make($data,$count,'15');
          

            return View::make('admin::lawyer/invoice.paid_bill')        
                    ->with('invoice',$payment);
        }
        $data= DB::query("select * from payment where payment_id IN(select max(payment_id) from payment where from_user = $uid and status = 1 group by to_user)");
        $count=count($data);
        $paginater=Paginator::make($data,$count,'15');
        return View::make('admin::lawyer/invoice.paid_bill')
                    ->with('invoice',$paginater);
    }
    public function get_PendingBill()
    {
       $uid=Auth::user()->id;
       if($_GET && array_filter(Input::all()))
        {
            Input::flash();
            $client_id=Input::get('client_id','0');
            $from=Input::get('from_date','01/01/1970');
            $from=($from) ? implode('-',array_reverse(explode('/',$from))):'1970-01-01';
            $to=Input::get('to_date','01/01/4015');
            $to=($to) ? implode('-',array_reverse(explode('/',$to))).' 23:59:59':'4015-01-01';
            if(!$client_id)
            {
                  if($from == $to)
                {
                    $data= DB::query("select * from payment where created_date LIKE ? AND payment_id IN(select max(payment_id) from payment where status = 0 AND from_user = $uid  group by to_user)",array("%$from%"));
                }
                else
                {

                 $data= DB::query("select * from payment where created_date between ? AND ? AND payment_id IN(select max(payment_id) from payment where status = 0 AND from_user = $uid  group by to_user)",array($from,$to));
                }
            }
            else
            {
                if($from == $to)
                {
                    $data=DB::query("select * from payment where payment_id IN(select max(payment_id) from payment where status = 0 AND from_user = $uid AND to_user = $client_id AND created_date LIKE ?  group by to_user)",array("%$from%"));
                }
                else
                {
                    $data=DB::query("select * from payment where payment_id IN(select max(payment_id) from payment where status = 0 AND from_user = $uid AND to_user = $client_id AND created_date between ? AND ? group by to_user)",array($from,$to));    
                }
            }
            $count=count($data);
            $payment=Paginator::make($data,$count,'15');
          

            return View::make('admin::lawyer/invoice.pending_bill')        
                    ->with('invoice',$payment);
        }
        $data= DB::query("select * from payment where payment_id IN(select max(payment_id) from payment where from_user = $uid and status = 0 group by to_user)");
        $count=count($data);
        $paginater=Paginator::make($data,$count,'15');
        return View::make('admin::lawyer/invoice.pending_bill')
                    ->with('invoice',$paginater);
    }
    public function get_HistoryInvoice()
    {
        if(Input::get())
        {
            
                $l=Input::get('l');
                $c=Input::get('c');
                $data=array('l'=>$l,'c'=>$c);
                $validator=Validator::make($data,array(
                    'l'=>'required|numeric',
                    'c'=>'required|numeric'));
                if($validator->fails())
                {
                    
                     return Response::error('404');
                }
                else
                {
                    if(Auth::user()->id == $l)
                    {
                        $invoice=DB::table('payment')->where_from_user($l)->where_to_user($c)
                                ->get();
                        return View::make('admin::lawyer/invoice.history_invoice')
                                    ->with('invoice',$invoice);
                    }
                    else
                    {
                         return Response::error('404');
                    }
                    
                }
        }
        else
        {
            return Response::error('404');
        }
    }

} 