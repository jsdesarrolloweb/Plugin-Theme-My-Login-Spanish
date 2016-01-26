<?php
/*
If you would like to edit this file, copy it to your current theme's directory and edit it there.
Theme My Login will always look in your theme's directory first, before using this default template.
*/
?>
<div class="login profile" id="theme-my-login<?php $template->the_instance(); ?>">
	<?php $template->the_action_template_message( 'profile' ); ?>
	<?php $template->the_errors(); ?>
	<form id="your-profile" action="<?php $template->the_action_url( 'profile' ); ?>" method="post">
		<?php wp_nonce_field( 'update-user_' . $current_user->ID ); ?>
		<p>
			<input type="hidden" name="from" value="profile" />
			<input type="hidden" name="checkuser_id" value="<?php echo $current_user->ID; ?>" />
		</p>


		<h3><?php _e( 'Opciones del Perfil', 'theme-my-login' ); ?></h3>

		<table class="form-table">
		<tr class="show-admin-bar user-admin-bar-front-wrap">
			<th><label for="admin_bar_front"><?php _e( 'Barra de Herramientas', 'theme-my-login' )?></label></th>
			<td>
				<label for="admin_bar_front"><input type="checkbox" name="admin_bar_front" id="admin_bar_front" value="1"<?php checked( _get_admin_bar_pref( 'front', $profileuser->ID ) ); ?> />
				<?php _e( 'Mostrar la barra de herramientas mientras estas viendo la web', 'theme-my-login' ); ?></label>
			</td>
		</tr>
		<?php do_action( 'personal_options', $profileuser ); ?>
		</table>

		<?php do_action( 'profile_personal_options', $profileuser ); ?>

		<h3><?php _e( 'Nombre', 'theme-my-login' ); ?></h3>

		<table class="form-table">
		<tr>
			<th><label for="user_login"><?php _e( 'Usuario', 'theme-my-login' ); ?></label></th>
			<td><input type="text" name="user_login" id="user_login" value="<?php echo esc_attr( $profileuser->user_login ); ?>" disabled="disabled" class="regular-text" /> <span class="description"><?php _e( 'Tu nombre de usuario no puede cambiarse.', 'theme-my-login' ); ?></span></td>
		</tr>

		<tr>
			<th><label for="first_name"><?php _e( 'Nombre', 'theme-my-login' ); ?></label></th>
			<td><input type="text" name="first_name" id="first_name" value="<?php echo esc_attr( $profileuser->first_name ); ?>" class="regular-text" /></td>
		</tr>

		<tr>
			<th><label for="last_name"><?php _e( 'Apellidos', 'theme-my-login' ); ?></label></th>
			<td><input type="text" name="last_name" id="last_name" value="<?php echo esc_attr( $profileuser->last_name ); ?>" class="regular-text" /></td>
		</tr>

		<tr>
			<th><label for="nickname"><?php _e( 'Nickname', 'theme-my-login' ); ?> <span class="description"><?php _e( '(requerido)', 'theme-my-login' ); ?></span></label></th>
			<td><input type="text" name="nickname" id="nickname" value="<?php echo esc_attr( $profileuser->nickname ); ?>" class="regular-text" /></td>
		</tr>

		<tr>
			<th><label for="display_name"><?php _e( 'Mostrar nombre publicamente como', 'theme-my-login' ); ?></label></th>
			<td>
				<select name="display_name" id="display_name">
				<?php
					$public_display = array();
					$public_display['display_nickname']  = $profileuser->nickname;
					$public_display['display_username']  = $profileuser->user_login;

					if ( ! empty( $profileuser->first_name ) )
						$public_display['display_firstname'] = $profileuser->first_name;

					if ( ! empty( $profileuser->last_name ) )
						$public_display['display_lastname'] = $profileuser->last_name;

					if ( ! empty( $profileuser->first_name ) && ! empty( $profileuser->last_name ) ) {
						$public_display['display_firstlast'] = $profileuser->first_name . ' ' . $profileuser->last_name;
						$public_display['display_lastfirst'] = $profileuser->last_name . ' ' . $profileuser->first_name;
					}

					if ( ! in_array( $profileuser->display_name, $public_display ) )// Only add this if it isn't duplicated elsewhere
						$public_display = array( 'display_displayname' => $profileuser->display_name ) + $public_display;

					$public_display = array_map( 'trim', $public_display );
					$public_display = array_unique( $public_display );

					foreach ( $public_display as $id => $item ) {
				?>
					<option <?php selected( $profileuser->display_name, $item ); ?>><?php echo $item; ?></option>
				<?php
					}
				?>
				</select>
			</td>
		</tr>
		</table>

		<h3><?php _e( 'Información de Contacto', 'theme-my-login' ); ?></h3>

		<table class="form-table">
		<tr>
			<th><label for="email"><?php _e( 'E-mail', 'theme-my-login' ); ?> <span class="description"><?php _e( '(requerido)', 'theme-my-login' ); ?></span></label></th>
			<td><input type="text" name="email" id="email" value="<?php echo esc_attr( $profileuser->user_email ); ?>" class="regular-text" /></td>
		</tr>

		<tr>
			<th><label for="url"><?php _e( 'Sitio Web', 'theme-my-login' ); ?></label></th>
			<td><input type="text" name="url" id="url" value="<?php echo esc_attr( $profileuser->user_url ); ?>" class="regular-text code" /></td>
		</tr>

		<?php
			foreach ( wp_get_user_contact_methods() as $name => $desc ) {
		?>
		<tr>
			<th><label for="<?php echo $name; ?>"><?php echo apply_filters( 'user_'.$name.'_label', $desc ); ?></label></th>
			<td><input type="text" name="<?php echo $name; ?>" id="<?php echo $name; ?>" value="<?php echo esc_attr( $profileuser->$name ); ?>" class="regular-text" /></td>
		</tr>
		<?php
			}
		?>
		</table>

		<h3><?php _e( 'Sobre ti', 'theme-my-login' ); ?></h3>

		<table class="form-table">
		<tr>
			<th><label for="description"><?php _e( 'Bio', 'theme-my-login' ); ?></label></th>
			<td><textarea name="description" id="description" rows="5" cols="30"><?php echo esc_html( $profileuser->description ); ?></textarea><br />
			<span class="description"><?php _e( 'Comparte un poco de información sobre ti para rellenar el perfil. Ésto se puede mostrar publicamente.', 'theme-my-login' ); ?></span></td>
		</tr>

		<?php
		$show_password_fields = apply_filters( 'show_password_fields', true, $profileuser );
		if ( $show_password_fields ) :
		?>
		<tr id="password">
			<th><label for="pass1"><?php _e( 'Nueva Contraseña', 'theme-my-login' ); ?></label></th>
			<td><input type="password" name="pass1" id="pass1" size="16" value="" autocomplete="off" /> <span class="description"><?php _e( 'Si desea cambiar la contraseña, escriba una nueva. De lo contrario dejarlo en blanco.', 'theme-my-login' ); ?></span><br />
				<input type="password" name="pass2" id="pass2" size="16" value="" autocomplete="off" /> <span class="description"><?php _e( 'Escribe la nueva contraseña de nuevo.', 'theme-my-login' ); ?></span><br />
				<div id="pass-strength-result"><?php _e( 'Indicador de contraseña', 'theme-my-login' ); ?></div>
				<p class="description indicator-hint"><?php _e( '<b>Sugerencia: La contraseña debe tener al menos siete caracteres. Para hacerla más fuerte, use letras mayúsculas y minúsculas, números y símbolos como ! " ? $ % ^ &amp; ).</b>', 'theme-my-login' ); ?></p>
			</td>
		</tr>
		<?php endif; ?>
		</table>

		<?php do_action( 'show_user_profile', $profileuser ); ?>

		<p class="submit">
			<input type="hidden" name="action" value="profile" />
			<input type="hidden" name="instance" value="<?php $template->the_instance(); ?>" />
			<input type="hidden" name="user_id" id="user_id" value="<?php echo esc_attr( $current_user->ID ); ?>" />
			<input type="submit" class="button-primary" value="<?php esc_attr_e( 'Actualizar Perfil', 'theme-my-login' ); ?>" name="submit" />
		</p>
	</form>
</div>
