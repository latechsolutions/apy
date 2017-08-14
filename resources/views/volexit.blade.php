@extends('layouts.app')

@section('content')

<div class="container" >
    <div class="row">
          @if($errors->any())
    <div class="alert alert-danger alert-dismissable fade in text-center col-md-6 col-md-offset-3">
       <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>

   <p class="text-center">
     {{ $errors->first() }}

      </p>    
    </div>
     @endif  
            @if(Session::has('message'))
    <div class="alert alert-success alert-dismissable fade in text-center col-md-6 col-md-offset-3">
       <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>

   <p class="text-center">
     {{ Session::get('message') }}

      </p>    
    </div>
     @endif
    <div class="alert alert-danger alert-dismissable fade in text-center col-md-6 col-md-offset-3"  style="display:none" id="errormsg">
       <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
 </div>
    
  </div>
    <div class="row">
     <div class="col-md-9 col-md-offset-1">
       <div class="table-responsive">
         <table class="table">
           <thead >
             <tr class="success">
               <th>Pran No.</th>
               <th>Subscriber Name</th>
               <th>Pension Amount</th>
               <th>Application Date</th>
               <th>Action</th>
             </tr>
           </thead>
           <tbody>
             @foreach($pranlist as $pran)
             <tr data-pran="{{ $pran->pran_no }}">
               <td>{{ $pran->pran_no }}</td><td>{{ $pran->sub_name }}</td><td>{{ $pran->pen_amt }}</td>
               <td>{{ $pran->appl_dt }}</td><td class="col-sm-2">
               <a class="btn btn-primary form-control" href="{{ url('volexit') }}/{{ $pran->pran_no }}">Exit</a>
               </td>
             </tr>
             @endforeach
           </tbody>
         </table>
       
<span class="col-md-offset-4"> {{ $pranlist->links() }}       </span>
       </div>
      </div>
 

    </div>
</div>
@endsection
@section('scripts')

@endsection
