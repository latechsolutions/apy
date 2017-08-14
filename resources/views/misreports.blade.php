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
            <form method="post" action="{{ url('findatamod') }}/{{ $action }}">
        {{ csrf_field() }}
      @if($action=='penupdw')
   <div class="col-md-6 well">
     <h3>
      Pran List
     </h3>
              <div class="form-group {{ $errors->has('brcd') ? ' has-error' : '' }}">
                <label class="control-label" for="brcd">Branch Code : </label>
                <input type="text" class="form-control" id="brcd" name="brcd" value="{{ old('brcd') }}" /> @if ($errors->has(''))
                <span class="help-block">
                                        <strong>{{ $errors->first('pranno') }}</strong>
                                    </span> @endif
              </div>
      <div class="form-group {{ $errors->has('penamt') ? ' has-error' : '' }}">
                <label class="control-label" for="penamt">Pension Amount : </label>
                <select class="form-control" id="penamt" name="penamt" >
            <option value="NA" selected>Select</option>
            <option value="1000">1000</option>
            <option value="2000">2000</option>
                  <option value="3000">3000</option>
                  <option value="4000">4000</option>
                  <option value="5000">5000</option>
          </select> @if ($errors->has('penamt'))
                <span class="help-block">
                                        <strong>{{ $errors->first('penamt') }}</strong>
                                    </span> @endif
              </div>
                   <div class="form-group {{ $errors->has('contramt') ? ' has-error' : '' }}">
                <label class="control-label" for="contramt">Contribution Amount : </label>
                <label class="control-label" id="contramtl" value="">{{ old('contramt') }}</label>
                <input type="hidden" class="form-control" id="contramt" name="contramt" value="{{ old('contramt') }}" /> @if ($errors->has('contramt'))
                <span class="help-block">
                                        <strong>{{ $errors->first('contramt') }}</strong>
                                    </span> @endif
              </div>
     <div class="form-group">
       <button type="submit" class="btn btn-warning form-control">
         Submit
       </button>
     </div>
      </div>
        @endif
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
    </form>
</div>
</div>
@endsection
@section('scripts')

@endsection
