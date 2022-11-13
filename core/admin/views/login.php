

    <style>
        body {
            background: linear-gradient(0deg, white 50%, #3786E5 50%);
        }
    </style>

    <div class="login-page">
        <form action="<?= PATH . 'admin/login'?>" method="post">
            <h2>Admin area</h2>
            <div class="block">
                <input name="name" type="text" placeholder="Username" class="field-blue">
            </div>
            <div class="block block-password" style="margin: 1em 0 0.8em;">
                <input name="password" type="password" placeholder="Password" class="field-blue">
                <svg class="icon icon-show"><use href="<?= $this->getImg('adminImg/'); ?>icons/icons.svg#showPassword"></use></svg>
            </div>
            
            
            <div class="f-block checkbox-blue">
                <input name="keeplogin" type="checkbox" id="keeplogin">
                <label for="keeplogin">
                    <span></span>
                    Keep me loged in
                </label>
            </div>
            <button>Login</button>
        </form>
    </div>

</body>
</html>