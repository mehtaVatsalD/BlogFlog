function handleHeight(textarea,height){
	textarea.style.height=height+'px';
	textarea.style.height=((height/2)+textarea.scrollHeight)+'px';
}

var cnt=0;
function dropDownShower() {
	if(cnt%2==0)
	{
		document.getElementsByClassName('dropDown')[0].style.display='block';
		document.getElementsByClassName('dropDownBack')[0].style.display='block';
		cnt++;
	}
	else if(cnt%2==1)
	{
		document.getElementsByClassName('dropDown')[0].style.display='none';
		document.getElementsByClassName('dropDownBack')[0].style.display='none';
		cnt++;
	}
}

function hideDropDown(){
	cnt++;
	document.getElementsByClassName('dropDown')[0].style.display='none';
	document.getElementsByClassName('dropDownBack')[0].style.display='none';
}

function searchUsers(userName){
	  var xhttp = new XMLHttpRequest();
	  xhttp.onreadystatechange = function() {
	    if (this.readyState == 4 && this.status == 200) {
	     document.getElementsByClassName("searchResult")[0].innerHTML = this.responseText;
	     // console.log(this.responseText);
	    }
	  };
	  xhttp.open("GET", "ajax/searchBlogger.php?blogger="+userName, true);
	  xhttp.send();
}

function readURL(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            document.getElementById('showProPic').setAttribute('src',e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }

    if(input.value!="")
    {
    	var error=document.getElementsByClassName(errorClasses['null']+'Of'+'uploadButton')[0];
    	if(error)
    		error.parentElement.removeChild(error);
    }
    else
    {
    	document.getElementById('showProPic').src='propics/default.png';
    }
}

function checkEnterPress(e,blogid)
{
	if(e.keyCode==13)
	{
		commentPlz(blogid);
	}
}

function showNotificationPanel(){
	var notPanel=document.getElementsByClassName('notifications')[0];
	
	if(notPanel.style.display=="")
	{
		notPanel.style.display="block";
		markAllRead();
	}
	else
	{
		notPanel.style.display="";
		// notPanel.innerHTML="<span>No Unread Notifications...</span>";
	}
}

function takeDelConf(blogid){
	document.getElementsByClassName('deleteCont')[0].style.display="block";
	document.getElementsByClassName('deleteConf')[0].style.display="block";
	var blog=event.target.parentElement;
	blog.setAttribute("id","deletingElement");
	document.getElementsByClassName('deleteSubmit')[0].setAttribute("onclick","deletePost("+blogid+")");
}

function completeDeleting(){
	document.getElementsByClassName('deleteCont')[0].style.display="none";
	document.getElementsByClassName('deleteConf')[0].style.display="none";
}

function showEditPopup(blogid){
	document.getElementsByClassName("blackback")[0].style.display="block";
	document.getElementsByClassName("editProfile")[0].style.display="block";
	var editTitle=document.getElementById('editTitle');
	var editPost=document.getElementById('editPost');
	var blog=event.target.parentElement;
	var title=blog.getElementsByClassName("blogTitles")[0].innerHTML;
	var post=blog.getElementsByClassName('mainContent')[0].getElementsByTagName('pre')[0].innerHTML;
	editTitle.value=title;
	editPost.value=post;

	editPost.style.height=editPost.scrollHeight+"px";

	document.getElementById('editPostBtn').setAttribute("onclick","editPost("+blogid+")");

}

function hideEditPopup(){
	document.getElementsByClassName("blackback")[0].style.display="none";
	document.getElementsByClassName("editProfile")[0].style.display="none";
}