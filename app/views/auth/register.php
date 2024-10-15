<?php use Core\formhelper; ?>
<?php $this->start('content'); ?>

<div class="row">
    <div class = "col-md-8 offset-md-2 poster">
    <h2>Register</h2>

    <form action="" method="POST">
        <div class="row">
            <?= formhelper::inputBlock('First Name', 'fname', '', ['class' => 'form-control'], ['class' => 'form-group col-md-6'], $this->errors);?>
            <?= formhelper::inputBlock('Last Name', 'lname', '', ['class' => 'form-control'], ['class' => 'form-group col-md-6'], $this->errors);?>
            <?= formhelper::inputBlock('Email', 'email', '', ['class' => 'form-control', 'type'=> 'email'], ['class' => 'form-group col-md-6'], $this->errors);?>
        </div>

         <div class="row">
            <?= formhelper::inputBlock('Password', 'password', '', ['class' => 'form-control', 'type'=> 'password'], ['class' => 'form-group col-md-6'], $this->errors);?>
            <?= formhelper::inputBlock('Confirm Password', 'confirm', '', ['class' => 'form-control', 'type'=> 'password'], ['class' => 'form-group col-md-6'], $this->errors);?>
        </div>

        <div class="txt-right">
            <a href="#" class="btn btn-secondary">cancel</a>
            <input class="btn btn-primary" value="Save" type="submit" />


    </form>

    </div>

</div>

<?php $this->end()?>

//view..rendered in the browser