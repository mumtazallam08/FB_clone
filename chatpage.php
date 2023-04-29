<?php 
	if(isset($_SESSION['name']))
	{
		include "dbconn.php"; 
		$sql="SELECT * FROM `chat`";
		$query = mysqli_query($conn,$sql);
?>
<style>
  h2{
color:white;
  }
  label{
color:white;
  }
  span{
	  color:#673ab7;
	  font-weight:bold;
  }
  .containeree {
    margin-top: 3%;
    width: 100%;
    background-color: skyblue;
    padding-right:10%;
    padding-left:10%;
  }
  .btn-primary {
    background-color: #673AB7;
	}
	.display-chatee{
		height:300px;
		background-color: skyblue;
		margin-bottom:4%;
		overflow:auto;
		padding:15px;
	}
	.messageee{
		background-color: #c616e469;
		color: white;
		border-radius: 5px;
		padding: 5px;
		margin-bottom: 3%;
	}
	.f-control{
		width: 70%;
		height: 30px;
		border-radius: 5px;
		border: 0px;
	}
	.l-primary{
		width: 25%;
		height: 30px;
		border-radius: 5px;
		border: 0px;
		font-size: larger;
		cursor: pointer;
	}
	.l-primary:hover{
		background-color: greenyellow;
	}
  </style>
  <center><h2>Welcome <span style="color: black;"><?php echo $_SESSION['name']; ?> !</span></h2>
  </center>
<div class="containeree">

  <div class="display-chatee">
<?php
	if(mysqli_num_rows($query)>0)
	{
		while($row= mysqli_fetch_assoc($query))	
		{
?>
		<div class="messageee">
			<p>
				<span><?php echo $row['name']; ?> :</span>
				<?php echo $row['message']; ?>
			</p>
		</div>
<?php
		}
	}
	else
	{
?>
<div class="messageee">
			<p>
				No previous chat available.
			</p>
</div>
<?php
	} 
?>

  </div>
  <form class="form-horizontal" method="post" action="sendMessage.php">
    <div class="form-group">
      <div class="col-sm-10">          
        <input name="msg" class="f-control" placeholder="Type your message here..." style="position: relative;"></input>
		<button type="submit" class="l-primary">Send</button>
      </div>
    </div>
  </form>
</div>

</body>
</html>
<?php
	}
	else
	{
		?>
<div class="messageee">
			<p>
				something went wrong....!
			</p>
</div>
<?php
	}
?>