<html>
    <head>
    </head>
    <body>
        <form>
            <div><label for="email">Email: </label> <input type="text" id="email" name="email"></div>
            <div><label for="password">Password: </label><input type="password" name="password" id="password"></div>
            <div>
                <button type="submit" id="login">Login</button></div>
        </form>
        <div id="token"></div>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha256-k2WSCIexGzOj3Euiig+TlR8gA0EmPjuc79OEeY5L45g=" crossorigin="anonymous"></script>
        <script src="https://www.gstatic.com/firebasejs/4.3.0/firebase.js"></script>
        <script>
            $(document).ready(function() {

                //Firebase
                var config = {
                    apiKey: "AIzaSyBO6GvEJ87w-b_fP_DNtFI-7el2T50qq-M",
                    authDomain: "ontime-88fdc.firebaseapp.com",
                    databaseURL: "https://ontime-88fdc.firebaseio.com",
                    projectId: "ontime-88fdc",
                    storageBucket: "ontime-88fdc.appspot.com",
                    messagingSenderId: "2368349126"
                };
                firebase.initializeApp(config);
                firebase.auth().onAuthStateChanged(function(user) {
                    if (user) {
                        console.log(user);
                        $('#token').html(user.De);
                    } else {
                        console.log('User signed out');
                    }
                });

                //Custom
                $('#login').on('click', function(event) {
                    event.preventDefault();
                    var email = $('#email').val();
                    var password = $('#password').val();
                    firebase.auth().signInWithEmailAndPassword(email, password).catch(function(error) {
                       console.error({'code': error.code, 'message': error.message});
                    });
                });
            });
        </script>
    </body>
</html>