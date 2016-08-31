<link rel="stylesheet" type="text/css" href="tabelstyle.css">
<?php
function ErrorMsg(){
echo"<div id='headerlogin'>
    <div id='kotaklogin'>
    <div id='kotakjudul' align='center'>
		<span class='judulhead'>Login</span>
            </div>
    <img src='img/n 64 & mario.png' width='128' height='105'  align='left'>

    <form method='POST' action='cek_login.php'>
    
    <table align=center><div id=username>
    <tr><td>NIP/No BP</td><td> : <input type='text' name='username' id=username title='isi no bp atau nik dengan benar'></td></tr>
    <tr><td>Level</td><td> : <select name='id_level'>
                                <option value=0 selected></option>";
                                $sql=mysql_query("SELECT * FROM level ORDER BY id_level");
                                while($data=mysql_fetch_array($sql)){
                                echo "<option value=$data[id_level]>$data[id_level] $data[level]</option>";
                                }
       echo "</select></td></tr>
    <tr><td>Password</td><td> : <input type='password' name='password' id=password title='isikan password anda dengan benar'></td></tr>
    <tr><td><input type='submit' value='Login'>
        <td><input type='reset' value='Reset'></td></td></tr></div>
        <td colspan='2'><div id='footer'>
    		Copyright &copy; 2011 by Roki Aditama </td>
    	</div>
    </table>
    </div>
    </form>
      </div>
    	
    </div>";
}
?>
