<?php
// Serviz 1.0.1 - Thomas de Roo - Licensed under MIT
// file: HomeView.class.php

class pInternView extends pSimpleView{

	public function renderAll(){
		
	}

	public function aboutEndUser(){
		
		// $about_us
		$aboutUs = file_get_contents(p::FromRoot("static/md/aboutus.md"));

		if(trim($aboutUs) == '')
			p::Url('?', true);

		// Change this to your likings, but please leave the part about serviz.
		return p::Out("
				".p::Markdown($aboutUs, true)."<div class='notice-subtle'>
				".(new pIcon('fa-info-circle'))." This website is powered by serviz 1.0.1, &copy; Thomas de Roo</div>");
	}

	public function about(){
		// Redirect the end-user
		if(!pUser::checkPermission(-3))
			return $this->aboutEndUser();

		p::Out((new pTabBar('serviz.','dots-horizontal-circle'))->addLink('about', 'About', null, true));
		p::Out("<div class='home-margin'>
			<br />
			<img src='".p::Url('library/staticimages/logo.png')."' style='height: auto;width:200px;'/><br /><br />
			<strong>serviz.</strong> – the dictionary toolkit<br />
			version 1.0.1 <br /><br />
			<div class='notice-subtle'>
				".(new pIcon('fa-info-circle'))." The end user cannot see this page, you can change what the end user sees (by default they will be redirected home) to your own about page by changing the contents of ".p::Markdown("`static\md\aboutus.md` to your likings.", false).".
			</div><br />
			<span class='tooltip small'>&copy; 2017 Thomas de Roo</span><br /><br />
		<div class='pLicense'>".p::Markdown(file_get_contents(p::FromRoot("LICENSE")), true)."</div></div>");
	}

}