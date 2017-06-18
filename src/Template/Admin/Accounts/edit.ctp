<?php

use Cake\Collection\Collection;

?>
<?php $this->start("heading"); ?>
Edit User Accounts
<?php $this->end("heading"); ?>
<?php
$this->Breadcrumbs->add("User Manager",[
	'action'=>'index'
]);
$this->Breadcrumbs->add("User Accounts",[
	'action'=>'index'
]);
$this->Breadcrumbs->add("Edit Account ID: {$userAccount->id}");

?>
<?= $this->Form->create($userAccount) ?>
    <div class="row">
        <div class="col-md-6">
			<div class="ibox float-e-margins">
				<div class="ibox-content white-bg">
					<h3>General</h3>
				<?php
					echo $this->Form->input('active',['data-on-text'=>'Active','data-off-text'=>'Off','data-on-color'=>'success']);
				?>
				<?php

						echo $this->Form->input('first_name');
						echo $this->Form->input('middle_name');
						echo $this->Form->input('last_name');
						echo $this->Form->input('email');
						echo $this->Form->input('profile_uri');
					?>
				</div>
			</div>
			<div class="ibox float-e-margins">
				<div class="ibox-content white-bg">
					<h3>Custom Fields</h3>
					<?php foreach ($userAccount->custom_fields as $k => $field): ?>
						<div class="custom-field">
							<?php echo $this->UserManager->customFieldEdit($field,$field->user_value,$k) ?>
						</div>
					<?php endforeach ?>
				</div>
			</div>
        </div>
        <div class="col-md-6">
				<div class="ibox">
					<div class="ibox-content white-bg float-e-margins groups">
						<h3>Group</h3>
							<?php
							$groupsCollection = new Collection($userAccount->user_account_groups);
							$selectedGroups = $groupsCollection->extract("id")->toArray();
							// pr($selectedGroups);
							foreach ($userGroups as $k => $v):
								$selected = false;
								if(in_array($k,$selectedGroups)) {
									$selected = true;
								}
							?>
							<?php echo $this->Form->input("user_account_groups.{$k}.id",['type'=>'checkbox','hiddenField'=>false,'value'=>$k,'label'=>$v,'checked'=>$selected,'required'=>false]) ?>
							<?php endforeach; ?>
					</div>
				</div>
				<div class="ibox">
					<div class="ibox-content white-bg">
						<h3>Login Providers</h3>
						<?php

							$providers = [];
							foreach($userAccount->user_account_login_provider_data as $k=>$v) {
								$providers[$v->provider][] = $v;
							}
						?>
						<?php foreach($providers as $k=>$v): ?>
							<div class="well">
								<div>
									<strong>Provider Name:</strong>
									<?= ucfirst($k) ?>
								</div>
								<?php foreach($v as $kk=>$vv): ?>
								<div>
								<strong><?= $vv->key_name ?>: </strong>
								<?= $vv->key_value ?>
								</div>
								<div>
									<strong>Created:</strong>
									<?= $vv->created ?>
								</div>
								<?php endforeach; ?>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
        </div>
    </div>
    <div class="form-actions">
        <button type="submit" class="btn btn-primary">
            <i class="fa fa-floppy-o"></i> Save
        </button>
    </div>
<?= $this->Form->end() ?>
<?php //pr($this); ?>
<?php pr($userAccount) ?>
