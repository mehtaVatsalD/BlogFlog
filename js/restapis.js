function usefullPost(blogid,element)
{
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
	if (this.readyState == 4 && this.status == 200) {
	 element.parentElement.innerHTML = this.responseText;
	 // console.log(this.responseText);
	}
	};
	xhttp.open("GET", "ajax/usefull.php?blogid="+blogid, true);
	xhttp.send();
}

function wastefullPost(blogid,element)
{
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
	if (this.readyState == 4 && this.status == 200) {
	 element.parentElement.innerHTML = this.responseText;
	 // console.log(this.responseText);
	}
	};
	xhttp.open("GET", "ajax/wastefull.php?blogid="+blogid, true);
	xhttp.send();
}

function followUser(bloggerName,userName)
{
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
	if (this.readyState == 4 && this.status == 200) {
		var resp=this.responseText;
		document.getElementsByClassName('followerPanel')[0].innerHTML=resp.split(':')[1]
		document.getElementsByClassName('followParent')[0].innerHTML=resp.split(':')[0];
	}
	};
	xhttp.open("GET", "ajax/follow.php?bloggerName="+bloggerName+"&userName="+userName, true);
	xhttp.send();
}

function blockUser(bloggerName)
{
	var parent=event.target.parentElement;
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
	if (this.readyState == 4 && this.status == 200) {
		parent.innerHTML=this.responseText;
	}
	};
	xhttp.open("GET", "ajax/blockUser.php?bloggerName="+bloggerName, true);
	xhttp.send();
}

function commentPlz(blogid){
	
	var child=event.target;
	var parent=child.parentElement;
	var grandParent=parent.parentElement;
	// console.log(parent,grandParent);
	var comment=parent.getElementsByClassName('commentInput')[0].value;
	parent.getElementsByClassName('commentInput')[0].value="";
	var data="comment="+comment+"&blogid="+blogid;
	//console.log(commentJSON);

	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
	if (this.readyState == 4 && this.status == 200) {
		// console.log(this.responseText);
		var div=document.createElement('div');
		div.innerHTML=this.responseText
		grandParent.insertBefore(div,parent);
	}
	};
	xhttp.open("POST", "ajax/comment.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send(data);
}

function markAllRead()
{
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
	if (this.readyState == 4 && this.status == 200) {
		document.getElementById('notiSymbolParent').innerHTML=this.responseText;
	}
	};
	xhttp.open("GET", "ajax/markAllRead.php", true);
	xhttp.send();
}

function deletePost(blogid)
{
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
	if (this.readyState == 4 && this.status == 200) {
		completeDeleting();
		var deletingElement=document.getElementById('deletingElement');
		deletingElement.parentElement.removeChild(deletingElement);
	}
	};
	xhttp.open("GET", "ajax/deletePost.php?blogid="+blogid, true);
	xhttp.send();
}

function viewMore(minId,minDbId,page,bloggerName)
{
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
	if (this.readyState == 4 && this.status == 200) {
		var container=document.getElementsByClassName('container')[0];
		var viewMore=document.getElementsByClassName('viewMore')[0];
		container.removeChild(viewMore);
		// var div=document.createElement('div');
		// div.innerHTML=this.responseText;
		container.innerHTML+=this.responseText;
		// console.log(this.responseText);
	}
	};
	xhttp.open("GET", "ajax/viewMore.php?minId="+minId+"&minDbId="+minDbId+"&page="+page+
		"&bloggerName="+bloggerName, true);
	xhttp.send();
}

function viewMoreCmts(minTime)
{
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
	if (this.readyState == 4 && this.status == 200) {
		var container=document.getElementsByClassName('notifications')[0];
		var viewMore=document.getElementsByClassName('viewMoreCmts')[0];
		container.removeChild(viewMore);
		// var div=document.createElement('div');
		// div.innerHTML=this.responseText;
		container.innerHTML+=this.responseText;
		// console.log(this.responseText);
	}
	};
	xhttp.open("GET", "ajax/viewMoreCmts.php?minTime="+minTime, true);
	xhttp.send();
}

function editPost(blogid)
{
	var title=document.getElementById('editTitle').value;
	var post=document.getElementById('editPost').value;
	var data="blogid="+blogid+"&title="+title+"&post="+post;
	var postTitle=document.getElementsByClassName('blogTitles'+blogid)[0];
	var mainContent=document.getElementsByClassName('mainContent'+blogid)[0];
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
	if (this.readyState == 4 && this.status == 200) {
		postTitle.innerHTML=title;
		mainContent.innerHTML="<pre>"+post+"</pre>";
		hideEditPopup();
	}
	};
	xhttp.open("POST", "ajax/editPost.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send(data);
}