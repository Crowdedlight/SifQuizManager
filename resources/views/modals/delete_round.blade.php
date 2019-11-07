<?php
echo BootForm::open(['route' => ['round.delete', 'id' => $id]]);
echo BootForm::hidden('_action', 'delete');
?>
<div class="bs-callout bs-callout-danger" >
    <label class="control-label">Are you sure you want to delete the round?</label>
    <br/>
    <p class="admissionUpdate">Round name: {{ $name }}</p>
    <p class="admissionUpdate">Number of teams: {{ $numTeams }}</p>
    <p class="admissionUpdate">Round status: {{ $status }}</p>
    <p class="admissionUpdate">Round active: {{ $active }}</p>
</div>
<?php
echo Button::submit()->danger()->withValue('Are you sure?')->block();
echo BootForm::close();