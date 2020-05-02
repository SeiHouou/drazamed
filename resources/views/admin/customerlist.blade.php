@include('admin/header')
<script>
$(function()
{
    $('#dash').removeClass('active');
    $('#users').addClass('active');
});
</script>
<section id="content">
<section class="vbox">
  <section class="scrollable padder">
  <div class="m-b-md">
                <h3 class="m-b-none">Customers</h3>
  </div>
  <section class="panel panel-default">
   <table class="table table-striped m-b-none dataTable">
	<thead>
	  <tr>
	    <th>{{ __('No.')}}</th>
	    <th>{{ __('Email')}}</th>
	    <th>{{ __('Phone')}}</th>
	    <th>{{ __('First Name')}}</th>
	    <th>{{ __('Last Name')}}</th>
	    <th>{{ __('Address')}}</th>
	    <th>{{ __('Pincode')}}</th>

	    <th></th>
	  </tr>
	</thead>
	<tbody>
	<?php
	if(count($customers)>0)
	{
	$pageNumber= Request::get('page');
	$i = 0;
	foreach($customers as $customer)
	{?>
	   <tr>
	   <td><?php echo(isset($pageNumber)? ($i+1+((Request::get('page')-1)*30)) : $i+1)?></td>
	   <td><?php echo $customer->mail; ?></td>
	   <td><?php echo $customer->phone; ?></td>
	   <td><?php echo $customer->first_name; ?></td>
	   <td><?php echo $customer->last_name; ?></td>
	   <td><?php echo $customer->address; ?></td>
	   <td><?php echo $customer->pincode; ?></td>
	   <td>
	   <a href="customer-delete/<?php echo $customer->id;  ?>" class="btn btn-s-md btn-danger btn-rounded" >Delete</a>&nbsp;&nbsp;&nbsp;
	   <?php  if($customer->user_status == UserStatus::PENDING()){ ?>
	   <a href="user-change-status/<?php echo $customer->id; ?>" class="btn btn-s-md btn-danger btn-rounded" >Publish</a>
	   <?php }?>
	   </td>
	   </tr>
	   <?php

	   $i++;
	   } } else {?>
	   <tr><td colspan="7">{{ __('No Customers Found.')}}</td></tr>
	   <?php }?>

	{{ $customers->links() }}
	</tbody>
	</table>
 </section>
</div>
 <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.2.min.js"></script>
  <script>
				$(document).ready(function(e){
				document.getElementById('searchTop').style.display = 'none';
				});
  </script>
@include('admin/footer')
