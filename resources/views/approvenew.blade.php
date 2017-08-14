@extends('layouts.app') @section('content')

<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
     <table class="table table-striped table-hover ">
        <thead>
          <tr>
       <th>Pran No</th>
            <th>Subscriber Name</th>
			<th> CBS A/c No</th>
            <th>Pension Amount</th>
            <th>Premium Amount</th>
			<th>Frequency</th>
          </tr>
        </thead>
        <tbody>
          <?php $i=1; ?>
          @foreach($pendingrec as $indivrec)
          <tr class="{{ $i%2==0?'success':'danger' }}" data-pran="{{ $indivrec->pran_no }}">
            <td>{{ $indivrec->pran_no }}</td>
            <td data-subname=" {{ $indivrec->sub_name }}">{{ $indivrec->sub_name }}</td>
			<td data-acno="{{ $indivrec->sub_ac_no }}">{{ $indivrec->sub_ac_no }}</td>
            <td>{{ $indivrec->pen_amt }}</td>
            <td>{{ $indivrec->contr_amt }}</td>
			<td>{{ $indivrec->pay_freq }}</td>
            <td><input type="button" class="btn btn-warning btn-sm" data-pran="{{ $indivrec->pran_no }}" 
                              id="selectbut{{ $i }}" value="Select" onclick="selectbutclick(this)" /></td>
            <?php $i++; ?>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>

<div id="approvediv" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
         <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h6 class="modal-title">Approve Details</h6>
      </div>
      <div class="modal-body " style="width:800px">
        <div class="row">
          
        <label class="control-label" id="prannol">Pran Number:</label>
        <label class="control-label" id="pranno" ></label>
		 <!--     <label class="control-label" id="subname">Subscriber Name:</label>
        <label class="control-label" id="subnamel" ></label>
		      <label class="control-label" id="acno">CBS A/c No:</label>
        <label class="control-label" id="acnol" ></label>  -->
        </div>
        <div class="row">
        <input type="button" id="rejectbut" class="btn btn-danger" data-pran="" value="Reject"></input>
        <input type="button" id="approvebut" class="btn btn-success" data-pran="" value="Approve"></input>
      </div>
      </div>
      </div>
  </div>
</div>
    
  </div>
</div>
@endsection

@section('scripts')
<script>
  function selectbutclick(clickedbutton)
  {
  $('#pranno').text($(clickedbutton).attr('data-pran'));
    $('#approvebut').attr('data-pran',$(clickedbutton).attr('data-pran'));
  $('#rejectbut').attr('data-pran',$(clickedbutton).attr('data-pran'));
$('#approvediv').modal();   
  }
  $(document).ready(function(){
 
$('#approvebut').click(function(){
  
         $.getJSON("{{ url('/approvenew/approve') }}/"+$('#approvebut').attr('data-pran'),
                   function(data){
            if(data.status=="success")
              {
                $('#approvediv').modal("hide");
                $("tr[data-pran='"+$('#approvebut').attr('data-pran')+"']").remove();
              }
            else
             {alert("Error in Approval.Please try again");}
          })
          .error(function(){
            alert("Error in Approval.Please try again");
          });
});
  
  $('#rejectbut').click(function(){
  
         $.getJSON("{{ url('/approvenew/reject') }}/"+$('#rejectbut').attr('data-pran'),
                   function(data){
            if(data.status=="success")
              {
                $('#approvediv').modal("hide");
                $("tr[data-pran='"+$('#rejectbut').attr('data-pran')+"']").remove();
              }
            else
             {alert("Error in Approval.Please try again");}
          })
          .error(function(){
            alert("Error in Approval.Please try again");
          });
});
});
  </script>
@endsection