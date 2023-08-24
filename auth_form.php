<div class="block block__auth vh-100">
	<div class="container py-5 h-100">
		<div class="row d-flex align-items-center justify-content-center h-100">
			<div class="col-md-8 col-lg-7 col-xl-6">
				<img src="img/draw2.svg" class="img-fluid" alt="Phone image">
			</div>

			<div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">

				<div class="d-flex justify-content-center mb-5">

					<h4>Вхід у систему</h4>


				</div>

				<form action="index.php" method="POST">
					<!-- Email input -->

					<div class="form-floating form-outline mb-4">
						<input type="text" id="authUsername" class="form-control" name="login" placeholder="Login" />
						<label class="" for="authUsername">Ім'я користувача</label>
					</div>

					<!-- Password input -->
					<div class="form-floating  form-outline mb-4">
						<input type="password" id="authLogin" class="form-control" name="password" placeholder="Password" />
						<label class="" for="authLogin">Пароль</label>
					</div>

					<div class="d-flex  mb-4">
						<!-- Checkbox -->
						<div class="form-check">
							<input class="form-check-input" type="checkbox" id="authRemember" name="remember" checked />
							<label class="form-check-label" for="authRemember"> Запам'ятати </label>
						</div>
						<!-- <a href="#!">Forgot password?</a> -->
					</div>

					<!-- Submit button -->
					<div class="d-grid mb-4">
						<button type="submit" class="btn btn-lg btn-primary">Увійти</button>
					</div>

				</form>


				<?php if ($_POST['login']) {
				?>
					<div class="row">
						<div class="col-sm-12">
							<p class="text-center p-3 mb-2 bg-danger text-white">
								<?php
								$auth = mysqli_query($connect, "SELECT salt FROM users WHERE `login` = '$login' LIMIT 1");
								if (mysqli_num_rows($auth) !== 1) {
									echo "Користувач не знайдений";
								} else {
									$auth1 = mysqli_query($connect, "SELECT * FROM users WHERE `login` = '$login' AND `password` = '$password' LIMIT 1");
									if (mysqli_num_rows($auth1) !== 1) {
										echo "Невірний пароль!";
									}
								}



								?>
							</p>

						</div>
					</div>
				<?php } ?>




			</div>
		</div>
	</div>

</div>