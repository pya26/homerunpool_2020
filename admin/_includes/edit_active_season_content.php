<div class="container-fluid px-4">
    <h1 class="mt-4">Edit Active Season</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
        <li class="breadcrumb-item active">Edit Active Season</li>
    </ol>

   <form class="row g-3 needs-validation" novalidate>
        <div class="col-md-3">        
            
            <label for="validationCustomActiveSeason" class="form-label">Activate Season</label>
            <select class="form-select" id="validationCustomActiveSeason" required>
                <option selected disabled value="">Choose...</option>
                <?php
                    foreach (list_of_seasons() as $key => $value) {
                        if($value["currently_active"] == 1){
                            print '<option value="'.$value["id"].'" selected>'.$value["name"].' Season</option>';
                        } else {
                            print '<option value="'.$value["id"].'">'.$value["name"].' Season</option>';
                        }
                    }
                    
                ?>
            </select>
            <div class="invalid-feedback">
                Please select a season to activate.
            </div>

            
        <div class="col-md-9">
            <button class="btn btn-primary mt-2" type="submit" id="submitActiveSeasonButton">Submit form</button>
        </div>
    </form>
    
    
    <div style="height: 100vh"></div>
</div>