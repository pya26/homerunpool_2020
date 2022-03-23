<div class="container-fluid px-4">
    <h1 class="mt-4">Create User</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
        <li class="breadcrumb-item active">Create User</li>
    </ol>

   
    <form name="createUserForm" id="createUserForm" class="row g-3" novalidate> <!-- removed class name for validation "needs-validation"-->
        <div class="col-md-12">
            <label for="validationCustom01" class="form-label">First name</label>
            <input type="text" class="form-control" id="validationCustom01" value="" required>
            <div class="valid-feedback">Looks good!</div>
            <div class="invalid-feedback">Please enter a first name.</div>

            <label for="validationCustom02" class="form-label">Last name</label>
            <input type="text" class="form-control" id="validationCustom02" value="" required>
            <div class="valid-feedback">Looks good!</div>
            <div class="invalid-feedback">Please enter a last name.</div>

            <label for="validationCustomEmail" class="form-label">Email</label>                            
            <input type="text" class="form-control" id="validationCustomEmail" aria-describedby="inputGroupPrepend" required>
            <div class="valid-feedback">Looks good!</div>
            <div class="invalid-feedback">Please enter an email.</div>

            <label for="validationCustomMobile" class="form-label">Mobile Number</label>                            
            <input type="text" class="form-control" id="validationCustomMobile" aria-describedby="inputGroupPrepend" required>
            <div class="valid-feedback">Looks good!</div>
            <!--<div class="invalid-feedback">Please enter an email.</div>-->

            <!--<label for="validationCustomPassword" class="form-label">Password</label>
            <input type="password" class="form-control" id="validationCustomPassword" placeholder="" />
            <div class="valid-feedback">Looks good!</div>
            <div class="invalid-feedback">Please enter a password.</div>

            <label for="validationCustomMobile" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="validationCustomPasswordConfirm"  placeholder="" />
            <div class="valid-feedback">Looks good!</div>
            <div class="invalid-feedback">Please confirm correct password.</div>-->
        </div>

        <!--<div class="col-12">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="invalidCheck" required>
                <label class="form-check-label" for="invalidCheck">Agree to terms and conditions</label>
                <div class="invalid-feedback">You must agree before submitting.</div>
            </div>
        </div>
        -->
        <div class="col-12">
            <button class="btn btn-primary" id="createUserFormButton" type="submit">Submit form</button>
        </div>
    </form>
    
    <div style="height: 100vh"></div>
    <div class="card mb-4"><div class="card-body">When scrolling, the navigation stays at the top of the page. This is the end of the static navigation demo.</div></div>
</div>