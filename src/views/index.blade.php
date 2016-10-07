@extends('backup::layouts.dblayout')
@section('content')

<div class="container">
					
				{!! Form::open(array('url'=>'sixsbackup/save',
				'class'=>'form-horizontal',
				'parsley-validate'=>'','novalidate'=>' ','id'=> 'settingsFormAjax'))
				!!}
				<?php
					$form = new Form;
				?>
				<div class="col-md-12">
					<fieldset>
						
						<legend>
							<div class="top_title">Backup Settings</div>
							<div class="pull-right" style="margin-top: -30px;">
								<a href="<?php echo url();?>/sixsbackup/download')}}" class="btn btn-sm btn-white"><i class="icon-file-download"></i> Manual Backup</a>
								
							</div>
							
						</legend>
						
						<?php foreach($results as $result): ?>
						<?php if($result->settings_input_type != 'hidden'): ?>
						<div class="form-group  " >
							<label  class=" control-label col-md-4 text-left"> <?php echo $result->settings_label;?> </label>
							
							<div class="col-md-6">
								<?php if($result->settings_input_type == 'textarea'): ?>
								{!! Form::textarea($result->settings_name, $result->settings_value,array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true'  )) !!} 
								<?php elseif($result->settings_input_type == 'select'): ?>
								<?php 
								$backup_frequency_opt = array( '12 hours' => 'Once in a day' ,  '7 days' => 'Once in a week' ,  '14 days' => 'Once in 2 weeks' ,  '30 days' => 'Once in a month' ); ?>
								<select name='backup_frequency' rows='5' id='backup_frequency' required class='form-control '>
								<?php 
									foreach($backup_frequency_opt as $key=>$val)
									{
										echo "<option  value ='$key' ".($result->settings_value == $key ? " selected='selected' " : '' ).">$val</option>"; 						
									}						
								?>
							</select>
							<?php elseif($result->settings_input_type == 'email'): ?>
							{!! Form::email($result->settings_name, $result->settings_value,array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true'  )) !!} 
							<?php else: ?>
							{!! Form::text($result->settings_name, $result->settings_value,array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true'  )) !!} 
							<?php endif; ?>
							
							</div> 
							<div class="col-md-2">
								
							</div>
						</div>
						<?php endif;?>
						<?php endforeach ;?>
						<br/>
						<br/>
					<div class="col-md-12 center-block">
					    <button type="submit" id="singlebutton" name="singlebutton" class="btn btn-primary center-block">
					        Save
					    </button>
					</div>
					</fieldset>
				</div>
				<div style="clear: both"></div>
				
				{!! Form::close() !!}
		
				</div>

@endsection	
