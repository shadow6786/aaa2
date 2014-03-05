<div class="container">
            <div class="row">
                <div class="span4 offset4">
                    <div class="signin">
                        <div id="logo">
                            <img src="<?php echo cdn_base('img/hoja_azul.png') ?>" alt="AAA Internacional Logo">
                        </div>
                        <div class="tab-content">
                            <div id="login" class="tab-pane active">
                                <div class="alert">
                                    <?php if(isset($err)){ echo $err; } ?>
                                </div>
                                <form action="<?php echo base_url("panel/auth/login"); ?>" accept-charset="utf-8" method="post">
                                    <p class="muted tac">
                                        Ingrese su usuario y contraseña
                                    </p>
                                    <div class="control-group">
                                        <div class="controls">
                                            <div class="input-prepend">
                                                <span class="add-on"><i class="icon-user"></i></span>
                                                <input type="text" id="usuario_usr" name="usuario_usr" placeholder="Usuario">
                                                <?php echo form_error('usuario_usr'); ?>
                                            </div>
                                        </div>
                                        <div class="controls">
                                            <div class="input-prepend">
                                                <span class="add-on"><i class="icon-lock"></i></span>
                                                <input type="password" id="password_usr" name="password_usr" placeholder="Contraseña">
                                                <?php echo form_error('password_usr'); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-inverse btn-block" type="submit">Ingresar</button>
                                </form>
                            </div>
                            <div id="forgot" class="tab-pane">
                                <form action="http://bizstrap.themeleaf.com/admin/index.html">
                                    <p class="muted tac">
                                        Enter your valid e-mail
                                    </p>
                                    <div class="control-group">
                                        <div class="controls">
                                            <div class="input-prepend">
                                                <span class="add-on"><i class="icon-envelope"></i></span>
                                                <input type="email" placeholder="mail@domain.com" required="required">
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-inverse btn-block" type="submit">Recuperar Cuenta</button>
                                </form>
                            </div>
                            <div id="signup" class="tab-pane">
                                <form action="http://bizstrap.themeleaf.com/admin/index.html">
                                    <div class="control-group">
                                        <div class="controls">
                                            <div class="input-prepend">
                                                <span class="add-on"><i class="icon-user"></i></span>
                                                <input type="text" placeholder="username">
                                            </div>
                                        </div>
                                        <div class="controls">
                                            <div class="input-prepend">
                                                <span class="add-on"><i class="icon-envelope"></i></span>
                                                <input type="email" placeholder="mail@domain.com">
                                            </div>
                                        </div>
                                        <div class="controls">
                                            <div class="input-prepend">
                                                <span class="add-on"><i class="icon-lock"></i></span>
                                                <input type="password" placeholder="password">
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-inverse btn-block" type="submit">Registrarse</button>
                                </form>
                            </div>
                        </div>

                        <ul class="inline">
                            <li><a class="muted" href="#login" data-toggle="tab">Iniciar Session</a></li>
                            <li><a class="muted" href="#forgot" data-toggle="tab">Olvido su contraseña</a></li>
                            <li><a class="muted" href="#signup" data-toggle="tab">Registrese</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <script src="../../ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="assets/js/vendor/jquery-1.9.1.min.js"><\/script>')</script>
        <script type="text/javascript" src="assets/js/vendor/bootstrap.min.js"></script>		</div>		</div>