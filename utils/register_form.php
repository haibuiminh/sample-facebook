<form id='register-form'>
  <div id="intro1" class="fb-body">Facebook helps you connect and share with the <br/>
  people in your life.</div>
  <div id="intro2" class="fb-body">Create an account</div>
  <div id="img2" class="fb-body"><img src="assets/images/world.png" /></div>
  <div id="intro3" class="fb-body">It's free and always will be.</div>
  <div id="form3" class="fb-body">
    <input placeholder="First Name" type="text" id="firstname" name="name1" />
    <input placeholder="Last Name" type="text" id="lastname"  /> <br>
    <input placeholder="Emai" type="text" id="email" /><br>
    <input placeholder="Re-enter email" type="text" id="remail"  /><br>
    <input placeholder="Password" type="password" id="password"  /><br>
    <input type="date" id="birthday"  /><br><br>
    <input type="radio" class="r-b" name="sex" value="male" id="male" />Male
    <input type="radio" class="r-b" name="sex" value="female" id="female" />Female<br><br>
    <p id="intro4">By clicking Create an account, you agree to our Terms and that 
    you have read our Data Policy, including our Cookie Use.</p>
    <button type="submit" style='text-align: center;' class="button2">Create an account</button>
    <br><hr>
    <p id="intro5">Create a Page for a celebrity, band or business.</p>
  </div>
  <script src="./handlers/registerHandler.js"></script>
</form>
