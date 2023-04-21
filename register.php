<?php



$first_name =$last_name = $username= $password = $confirm_password ='';
$first_name_err = $last_name_err = $username_err = $password_err =$confirm_password_err = '';

$validate_failed=false ;

if (!empty($_SESSION['logged_in']) && $_SESSION['logged_in'] ==true) {
    header('location:index.php');
    
}


if(isset($_POST['submit'])) {

    require_once 'db-connect.php';

    $checkUser = "SELECT username from users where username= '".$username."'";
    $result2= mysqli_query($con, $checkUser);
    $count = mysqli_num_rows($result2);

   
    


    //first name validation
    if(empty(trim($_POST['first_name']))){
        $first_name_err="please enter first name";
        $validate_failed=true ;
    }else{
        $first_name = trim($_POST['first_name']);
    }
    //last name validation
    if(empty(trim($_POST['last_name']))){
        $last_name_err="please enter last name";
        $validate_failed=true ;
    }else{
        $last_name = trim($_POST['last_name']);
    }


    //username validation
    if (empty(trim($_POST['username']))){
        $username_err = "Please enter username";
        $validate_failed=true ;
    }else{
        $username = trim($_POST['username']);

        if ($count > 0 ) {
            echo "username already exist";
            header('location:register.php');
        }
    }

    //password validation
    if (empty(trim($_POST['password']))){
        $password_err = "Please enter password";
        $validate_failed=true ;
    } else{
        $password = trim($_POST['password']);
    }
    //confirm password validation
    if (empty(trim($_POST['confirm_password']))){
        $confirm_password_err = "Please confirm password";
        $validate_failed=true ;
    } else{
        $confirm_password = trim($_POST['confirm_password']);
    }
    //check if password and confirm password are same
    if ($password != $confirm_password) {
        $confirm_password_err = "password do not match";
        $validate_failed=true ;
        
    }
    if (!$validate_failed){
            $stm =$con-> prepare("INSERT INTO users(first_name,last_name , username,password,registered_date,status)VALUES(?,?,?,?,?,?)");
            $status='active';
            $registered_date= time();
            $hashed_password= sha1($password);
            $stm -> bind_param('ssssis',$first_name,$last_name,$username, $hashed_password,$registered_date,$status);
            $result=$stm->execute();
           
           if ($result) {
               header('location:login.php');
   
               
           }else{
               $error='Something went wrong';
           }
   
    
        
    }
    
    
    
    
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css" >
    <title>Register</title>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-6">
             <div class="card">
                <div class="card-body">
                   <h3 class="card-title">Register</h3>
                   <form class="form" method="post">
                        <?php if(!empty($error)): ?> 
                           <div class="alert alert-danger" role="alert">
                           <?=$error?>
                           </div>
                        <?php endif; ?>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control <?= empty($first_name_err) ? '' : 'is-invalid' ?>" value="<?=$first_name?>" name="first_name" id="first_name">
                            <label for="first_name">First name</label>
                            <?php if(!empty($first_name_err) && empty(trim($_POST['fist_name']))): ?>
                                <div class="invalid-feedback"><?=$first_name_err?></div>
                                
                            <?php endif; ?>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control <?= empty($last_name_err) ? '' : 'is-invalid' ?>" value="<?=$last_name?>" name="last_name" id="last_name">
                            <label for="last_name">Last name</label>
                            <?php if(!empty($last_name_err) && empty(trim($_POST['last_name']))): ?>
                                <div class="invalid-feedback"><?=$last_name_err?></div>
                                
                            <?php endif; ?>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control <?= empty($username_err) ? '' : 'is-invalid' ?>" value="<?=$username?>" name="username" id="username">
                            <label for="username">User name</label>
                            <?php if(!empty($username_err) && empty(trim($_POST['username']))): ?>
                                <div class="invalid-feedback"><?=$username_err?></div>
                                
                            <?php endif; ?>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control <?= empty($password_err) ? '' : 'is-invalid' ?>" name="password" id="password">
                            <label for="password">Password</label>
                            <?php if(!empty($password_err) && empty(trim($_POST['password']))): ?>
                                <div class="invalid-feedback"><?=$password_err?></div>
                            <?php endif; ?>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control <?= empty($confirm_password_err) ? '' : 'is-invalid' ?>" name="confirm_password" id="confirm_password">
                            <label for="confirm_password">Confirm Password</label>
                            <?php if(!empty($confirm_password_err) && empty(trim($_POST['confirm_password']))): ?>
                                <div class="invalid-feedback"><?=$confirm_password_err?></div>
                            <?php endif; ?>
                        </div>
                        <div class="d-grid">
                            <button type="submit" name="submit" class="btn btn-primary" style="width: 60px; height: 35px; padding: 0%;" >Register</button>
                        </div>
                   </form>
                   
                </div>
             </div>
                
            </div>

        </div>
        
    </div>
    
</body>
</html>
