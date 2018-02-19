<div class="input-group pull-right">
    <form method="POST" action="{{ route('finance.search_payment_list') }}" class="navbar-form navbar-left" role="search">
        {{ csrf_field() }}
        <div class="form-group">
            <input type="text" name="search_payment_list" size="25" class="form-control" placeholder="Can't find a patient: search here">
        </div>
        <button type="submit" class="btn btn-info"><i class="fa fa-search"></i></button>
    </form>
</div>