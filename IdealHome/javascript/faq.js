window.onload=function(){
	var faqList,answers,questionLinks,questions,currentNode,i,j;
	faqList=document.getElementById("faq");
	answers=faqList.getElementsByTagName("dd");
	for(i=0;i<answers.length;i++){
		answers[i].style.display='none';
	}
	questions = faqList.getElementsByTagName("dt");
	for (i=0;i<questions.length;i++){
		questions[i].onclick=function(){
		currentNode=this.nextSibling;
		while(currentNode){
			if(currentNode.nodeType=="1" && currentNode.tagName=="DD"){
				if (currentNode.style.display=='none'){
					currentNode.style.dislay='block';
				}
				else{
					currentNode.style.display='none';
				}
				break;
			}
			currentNode=currentNode.nextSibling;
		}
		return false;
	};
}
}