<?php /**
 * Created by PhpStorm.
 * User: bhoo
 * Date: 1/28/14
 * Time: 12:19 PM
 */ ?>

<?php echo Section::start('contentWrapper');?>
<style type="text/css">

	table { page-break-after:avoid  }
	tr    { page-break-inside:avoid; page-break-after:auto }
	td    { page-break-inside:avoid; page-break-after:auto }
	thead { display:table-header-group }
	tfoot { display:table-footer-group }
	div.breakhere{ page-break-before: avoid}
	.page{page-break-after: always;page-break-inside: avoid}
	.center{text-align: center}
</style>
<?php  $lawyer=liblawyer::getlawyer(); ?>
<div class="page">

	<div class="page-header">
		<div class="right">
			<input type="button"   onClick="window.print()" value="Print This Page"><a class="btn btn-mini" href="<?php echo URL::to_route('SelectReport'); ?>">Back</a>
		</div>

		<div class="center">
			<h3><?php echo get_value_from_multi_object_array(Auth::user()->id, $lawyer, 'id', 'first_name').'&nbsp;'.get_value_from_multi_object_array(Auth::user()->id, $lawyer, 'id', 'last_name'); ?></h3>
			<h4>Case Report</h4>

		</div>
	</div>
	<?php $res = translation_array(); ?>
	<div class="widget-box">
		<div class="widget-header widget-header-flat">
			<h4>Cases</h4>
		</div>
		<div class="widget-body">
			<div class="widget-main">
				  <table class="table table-striped table-bordered">
					  <thead>
						<tr>
							<th>S.no</th>
						   <th>Case Name</th>
						   <th>Case Number</th>
						   <th>Case Type</th>
						   <th>Case Subject</th>
						   <th>Associate Lawyer</th>
						   <th>Case Description</th>
						   <th>Date of Filling</th>
							<th>Case Status</th>
						</tr>
					  </thead>
					  <tbody>
					  <?php $i=1; foreach ($report as $reports) { ?>
						<tr>
							<td><?php echo ucfirst($i);$i++; ?></td>
							<td><?php echo '<b>' . ucfirst($reports->case_name) . '</b>'; ?></td>
							<td><?php echo '<b>'.ucfirst($reports->case_no).'</b>'; ?></td>
							<td><?php echo '<b>'.ucfirst($reports->case_type).'</b>'; ?></td>
							<td><?php echo '<b>'.ucfirst($reports->case_subject).'</b>'; ?></td>
							<td><?php echo '<b>'.ucfirst(get_multi_value_from_object_array($reports->associate_lawyer,$lawyer,'id','first_name')).'</b>'; ?></td>
							<td><?php echo '<b>'.ucfirst($reports->case_description).'</b>'; ?></td>
							<td><?php echo '<b>'.date('d-M-Y',strtotime($reports->date_of_filling)).'</b>'; ?></td>
							<td><?php  if($reports->status==0){echo "<b>Pending</b>";}elseif($reports->status==1){echo "<b>Processing</b>";}elseif($reports->status==2){echo "<b>Completed</b>";} ?></td>
						</tr>
					  <?php } ?>
					  </tbody>

				  </table>
			</div>
		</div>
	</div>
	<?php foreach ($report as $reports) {$hearings = libreport::getcaseHearingDetailsByCaseID($reports->case_id);if($hearings!=NULL){ ?>
	<div class="widget-box breakhere">
		<div class="widget-header widget-header-flat">
			<h4>Hearings - <?php echo ucfirst($reports->case_name) . '(' . $reports->case_no . ')'; ?></h4>
		</div>

		<div class="widget-body">
			<div class="widget-main">
				<table class="table table-striped table-bordered">
					<thead>
					<tr>
						<th>S. No</th>
						<th>Hearing Date</th>
						<th>Associate</th>
						<th>Description</th>
						<th>Court Hall</th>
						<th>Judge</th>
						<th>Stage</th>
					</tr>
					</thead>
					<tbody>
					<?php $i=1; foreach($hearings as $hearing){ ?>
						<tr onclick="document.location.href='<?php echo URL::to_route('HearingDetail').'/'.$hearing->hearing_id;  ?>'" style="cursor: pointer">
								<td><?php echo $i;$i++; ?></td>
								<td><?php echo date('d-M-Y',strtotime($hearing->next_hearing_date)); ?></td>
								<td><?php echo '<b>'.ucfirst(get_multi_value_from_object_array($hearing->associate_lawyer,$lawyer,'id','first_name')).'</b>'; ?></td>
								<td><?php echo '<b>'.ucfirst($hearing->description).'</b>'; ?></td>
								<td><?php echo '<b>'.ucfirst($hearing->court_hall).'</b>'; ?></td>
								<td><?php echo '<b>'.ucfirst($hearing->judge).'</b>'; ?></td>
								<td><?php echo '<b>'.ucfirst($hearing->stage).'</b>'; ?></td>
						</tr>
					<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div> <!--END of Rearing Widget-->
	<?php }} ?>
</div>



<?php Section::stop(); ?>
<?php echo render('admin::lawyer/template.main1'); ?>


	