@extends('Fronted.layouts.master')

@section('title')
    Sign up
@endsection

@section
<section class="s-about signup">
    <div class="container">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <form action="{{url('User.sign_up')}}" method="post">

                    @csrf

                    <label><b>Name</b></label>
                    <input type="text" placeholder="Name" >
                    <label><b>Phone</b></label>
                    <input type="text" placeholder="Phone" >
                    <label><b>Email</b></label>
                    <input type="text" placeholder="Email" required>
                    <label><b>Password</b></label>
                    <input type="text" placeholder="Password" required>
                    <label><b>Re password</b></label>
                    <input type="text" placeholder="Repassword" ><br />
                    <input type="checkbox" checked="checked">Remember


                    <br />
                    <div class="clearfix">
                        <button id="#submit" type="submit" class="btn">Sign up</button>

                    </div>


                </form>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
</section>

@endsection

