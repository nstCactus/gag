{$session|flash}
<form action="{[ 'controller' => 'user', 'action' => 'login' ]|route}" class="LoginForm">
    <fieldset class="LoginForm_fieldset">
        <legend class="LoginForm_legend">{'loginForm.login'|dico:'Connexion'}</legend>
        <label
                class="LoginForm_label"
                for="email_field"
        >{'loginForm.email'|dico:'E-mail'}</label>
        <input
                id="email_field"
                class="LoginForm_input"
                name="email"
        >

        <label
                class="LoginForm_label"
                for="password_field"
        >{'loginForm.password'|dico:'Mot de passe'}</label>
        <input
                id="password_field"
                class="LoginForm_input"
                name="password"
        >
    </fieldset>

    <button class="LoginForm_button LoginForm_button-submit">{'loginForm.submitButton'|dico:'Connexion'}</button>
</form>
