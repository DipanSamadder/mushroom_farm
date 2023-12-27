@if(!empty(dsld_get_setting('dashboard_notifications')) && dsld_get_setting('dashboard_notifications') != 'Notification' && dsld_get_setting('dashboard_notifications') != 'Notifications')
@php 
	$dashboard_notifications = dsld_get_setting('dashboard_notifications');
@endphp
<div class="alert alert-warning" role="alert">
    <?php echo htmlspecialchars_decode($dashboard_notifications); ?>
</div>

@endif