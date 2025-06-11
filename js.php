
<?php
$msg_path=realpath(dirname(__FILE__)."/../../admin/msg/$domain.txt");
//页面背景路径
if(file_exists($msg_path))
	$view_marquee_msg=file_get_contents($OJ_SAE?"saestor://web/msg.txt":$msg_path);
else
	$view_marquee_msg="";


?>
<!--  to enable mathjax in hustoj:
svn export http://github.com/mathjax/MathJax/trunk /home/judge/src/web/mathjax
<script type="text/javascript"
  src="mathjax/MathJax.js?config=TeX-AMS-MML_HTMLorMML">
</script>
-->
<!--
or
<script type="text/javascript"
  src="https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML">
</script>

-->
<script src="<?php echo $OJ_CDN_URL.$path_fix."template/bs3/"?>bootstrap.min.js"></script>
<script>
$(document).ready(function(){
  var msg="<marquee style='margin-top:-10px;margin-bottom:10px' id=broadcast direction='left' scrollamount=3 scrolldelay=50 onMouseOver='this.stop()'"+
      " onMouseOut='this.start()' class='padding' >"+<?php echo json_encode($view_marquee_msg); ?>+"</marquee>";
  <?php if ($view_marquee_msg!="") { ?>
		$("#main").prepend(msg);
  <?php } ?>
  $("form").append("<div id='csrf' />");
  $("#csrf").load("<?php echo $path_fix?>csrf.php");
  let left=window.innerWidth-parseInt($("#menu").css("width")) - 100;
  left/=2;
  $("#menu").attr("style","margin-left:auto;margin-right:auto;");
  var screen_width = window.screen.width;
  var screen_height = window.screen.height;
  if(screen_width < 800) $("#main").attr("class","");
  if(screen_width < 800) $("#MainBg-C").attr("class","");

<?php if(isset($OJ_BG)&&$OJ_BG!="") echo " $('body').css('background','url($OJ_BG)').css('background-repeat','no-repeat').css('background-size','100%'); " ?>
  if(window.location.href.indexOf("rank")==-1){
	  $("tr").mouseover(function(){$(this).addClass("active")});
	  $("tr").mouseout(function(){$(this).removeClass("active")})
  }

<?php if(isset($_SESSION[$OJ_NAME."_administrator"]) ||isset($_SESSION[$OJ_NAME."_problem_editor"]) || isset($_SESSION[$OJ_NAME."_tag_adder"])  ){  ?>
	$("div[fd=source]").each(function(){
		let pid=$(this).attr('pid');	
		$(this).append("<span><span class='label label-success' pid='"+pid+"' onclick='problem_add_source(this,"+pid+");'>+</span></span>");
	});

<?php  } ?>

});


function problem_add_source(sp,pid){
	console.log("pid:"+pid);
	let p=$(sp).parent();
	p.html("<form onsubmit='return false;'><input type='hidden' name='m' value='problem_add_source'><input type='hidden' name='pid' value='"+pid+"'><input type='text' class='input input-large' name='ns'></form>");
	p.find("input").focus();
	p.find("input").change(function(){
		console.log(p.find("form").serialize());
		let ns=p.find("input[name=ns]").val();
		console.log("new source:"+ns);
		$.post("admin/ajax.php",p.find("form").serialize());
		p.parent().append("<span class='label label-success'>"+ns+"</span>");
		p.html("<span class='label label-success' pid='"+pid+"' onclick='problem_add_source(this,"+pid+");'>+</span>");
	});
}
$(".hint pre").each(function(){
        var plus="<span class='glyphicon glyphicon-plus'><?php echo $MSG_CLICK_VIEW_HINT?></span>";
        var content=$(this);
        $(this).before(plus);
        $(this).prev().click(function(){
                content.toggle();
        });
   //     $(this).hide();
});


  console.log("If you want to change the appearance of the web pages, make a copy of bs3 under template directory.\nRename it to whatever you like, and change the $OJ_TEMPLATE value in db_info.inc.php\nAfter that modify files under your own directory .\n");
  console.log("To enable mathjax in hustoj, check line 15 in /home/judge/src/web/template/bs3/js.php");
  console.log( "█████████████████████████████████████████\n████ ▄▄▄▄▄ ██▄▄ ▀  █▀█▄▄██ ███ ▄▄▄▄▄ ████\n████ █   █ █▀▄  █▀██ ██▄▄  █▄█ █   █ ████\n████ █▄▄▄█ █▄▀ █▄█▀█  ▄▄█▀▀▄██ █▄▄▄█ ████\n████▄▄▄▄▄▄▄█▄▀▄█ █ █▄█▄▀ █ ▀▄█▄▄▄▄▄▄▄████\n████ ▄▀▀█▄▄ █▄ █▄▄▄█▄█▀███▄  ██▀ ▄▀▀█████\n████▀█▀▀▀▀▄▀▀▄▀ ▄▄█▄ █▀▀ ▄▀▀▄  █▄▄▀▄█████\n████▄█ ▀▄▀▄▄ ▄ █▀█▀█ ▄▀▄ █▀▀▄█  ███  ████\n████▄ █▄ █▄▀▀▄██▀▄ ▄ ▄▄█▄█▀█▀   ▄█▀▄▀████\n████▄▄█   ▄▄██ █▄▄▀  ▄▀█▀▀▀ ▄█▀▄▄▀█ ▀████\n█████▄   ▀▄▄█ ▄▀▄▄▀▄▄▄▀▄▀█▀  ▀▀█▄█▀█▄████\n████ ▀ █▄▀▄▄█▀▀▄▀▀▄▄▄ ▀▀█▀ ▀▄▄█▀ ▀█ █████\n████ █▀   ▄ ▄ ▀█▀▄█ █▄▄███▀██▀▀██ ▀▄█████\n████▄▄▄██▄▄█ ▀█▄▄▄▀█ █▀▀█▀ █ ▄▄▄ █▀▄▀████\n████ ▄▄▄▄▄ █ ▄  ▄▄▀  ▄ ▀▄▄▄▄ █▄█   ▄█████\n████ █   █ ██ ▄▄▀▀█ ▀▀▀▀▀ ▄▀  ▄  ▀███████\n████ █▄▄▄█ █▀▄▄▄▀▀█ ▀▄ ▄▀██▄█ ██ █ █▄████\n████▄▄▄▄▄▄▄█▄███▄█▄▄▄████▄▄▄▄▄▄█▄██▄█████\n█████████████████████████████████████████\n            QQ扫码加官方群");
</script>

