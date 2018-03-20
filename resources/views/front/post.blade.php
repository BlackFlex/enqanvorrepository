@extends('front.layout')

@section('css')
    @if (Auth::check())
        <link rel="stylesheet" href="//cdn.jsdelivr.net/sweetalert2/6.3.8/sweetalert2.min.css">
    @endif
@endsection

@section('main')
<form id="PostAdMainForm" action="http://localhost/blog/public/addpost?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3RcL2Jsb2dcL3B1YmxpY1wvYXBpXC9hdXRoZW50aWNhdGUiLCJpYXQiOjE1MTY0MzkyMDQsImV4cCI6MTUxNjQ0MjgwNCwibmJmIjoxNTE2NDM5MjA0LCJqdGkiOiI0cEFMTHJndTViclFTNzFiIiwic3ViIjoyMywicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyJ9.iuYsrk-F5Pp9f6gE2OQf4zeCffNYuH5NoMYGh9sa-yU" method="post"><input id="" name="ca.kijiji.xsrf.token" value="1516428763315.20231433854fa1aa04f2406445f2a6c6" type="hidden">
<div id="MainForm" class="container-forms">

    <div style="display: none">
    <li class="jsonly">
        <div id="ImageUpload" class="clearfix form-section placeholders">

            <p class="images-title">Add at least one photo to complete your ad.</p>

            <div class="images-content">
                <h3>Add photos to attract interest to your ad</h3>
                <p>Include pictures with different angles and details. You can upload a maximum of <span id="MaxImages">10</span> photos, that are at least 300px wide or tall (we recommend at least 1000px).</p>
                <p>Drag and drop to change the order of your pictures.</p>
            </div>
            <ol id="UploadedImages">
                <li class="pic-placeholder"><div class="image-area" style="background-image: url(https://ca.classistatic.com/static/V/5783.4/img/placeHolder/generic.svg);"></div><div class="image-toolbar"></div></li><li class="pic-placeholder"><div class="image-area" style="background-image: url(https://ca.classistatic.com/static/V/5783.4/img/placeHolder/generic.svg);"></div><div class="image-toolbar"></div></li><li class="pic-placeholder"><div class="image-area" style="background-image: url(https://ca.classistatic.com/static/V/5783.4/img/placeHolder/generic.svg);"></div><div class="image-toolbar"></div></li><li class="pic-placeholder"><div class="image-area" style="background-image: url(https://ca.classistatic.com/static/V/5783.4/img/placeHolder/generic.svg);"></div><div class="image-toolbar"></div></li><li class="pic-placeholder"><div class="image-area" style="background-image: url(https://ca.classistatic.com/static/V/5783.4/img/placeHolder/generic.svg);"></div><div class="image-toolbar"></div></li><li class="pic-placeholder"><div class="image-area" style="background-image: url(https://ca.classistatic.com/static/V/5783.4/img/placeHolder/generic.svg);"></div><div class="image-toolbar"></div></li><li class="pic-placeholder"><div class="image-area" style="background-image: url(https://ca.classistatic.com/static/V/5783.4/img/placeHolder/generic.svg);"></div><div class="image-toolbar"></div></li><li class="pic-placeholder"><div class="image-area" style="background-image: url(https://ca.classistatic.com/static/V/5783.4/img/placeHolder/generic.svg);"></div><div class="image-toolbar"></div></li><li class="pic-placeholder"><div class="image-area" style="background-image: url(https://ca.classistatic.com/static/V/5783.4/img/placeHolder/generic.svg);"></div><div class="image-toolbar"></div></li><li class="pic-placeholder"><div class="image-area" style="background-image: url(https://ca.classistatic.com/static/V/5783.4/img/placeHolder/generic.svg);"></div><div class="image-toolbar"></div></li></ol>

            <span class="field-message" data-for="FileUploadInput"></span>

            <div id="ImageDragAndDrop" class="clearfix">
                <div class="image"></div>
                <div class="copy">
                    <h3>Drag and Drop</h3>
                </div>
            </div>

            <input name="images" type="hidden">
            </div>
    </li>
</div>
<input id="ca.kijiji.fraud.token" name="postAdForm.fraudToken" value="2154ea03c7152238bfd214872a0bfe59" type="hidden">
    <div class="container-info">
        <input name="uuid" value="" type="hidden">
        <input id="pstad-geourl" value="http://www.google.com/jsapi?" type="hidden">
        <input id="postad-id" name="adId" value="" type="hidden"><input id="GalleryImageIndexField" name="postAdForm.galleryImageIndex" value="" type="hidden"><input id="pstad-dflt-latitude" value="46.236591" type="hidden">
        <input id="pstad-dflt-longitude" value="-63.12817" type="hidden">
        <input id="pstad-lat" name="postAdForm.geocodeLat" value="0.0" type="hidden"><input id="pstad-lng" name="postAdForm.geocodeLng" value="0.0" type="hidden"><input id="pstad-city" name="postAdForm.city" value="" type="hidden"><input id="pstad-province" name="postAdForm.province" value="" type="hidden"><input id="PostalLat" name="PostalLat" type="hidden">
        <input id="PostalLng" name="PostalLng" type="hidden">
        <input id="categoryId" name="categoryId" value="12" type="hidden"><h2>
            <div class="number">1</div>Ad Details<div class="add-asterisk"> = mandatory fields</div>
        </h2>

        <ul class="post-ad-layout">
                <li class="category">
                <label>Select Category:</label>

                <div class="form-section">
                        <strong>
                                Buy &amp; Sell</strong>
                        
                            &gt;
                        <strong>
                                Arts &amp; Collectibles</strong>
                        <a href="/p-select-category.html" id="PostAdChangeCategory" class="post-ad-begin" data-btn-loc="pst-chng-cat">Change category</a>
                    </div>
            </li>

                <li>
                    <label for="postAdForm.adType" class="add-asterisk">Ad Type:</label><div class="form-section">
                        <label class="radio-button-content">
                                <input id="adType1" name="postAdForm.adType" value="OFFER" checked="checked" type="radio"><label for="adType1" class="radio-button-rd">
                                    <div class="inner-circle"></div>
                                </label>
                                <span class="radio-label">
                                    I am offering<span class="example"> - You are offering an item for sale</span>
                                </span>
                            </label>
                        <label class="radio-button-content">
                                <input id="adType2" name="postAdForm.adType" value="WANTED" type="radio"><label for="adType2" class="radio-button-rd">
                                    <div class="inner-circle"></div>
                                </label>
                                <span class="radio-label">
                                    I want<span class="example"> - You want to buy an item</span>
                                </span>
                            </label>
                        </div>
                </li>
            <li>
                    <a name="postAdForm.priceAmount"></a>
                    <label for="PriceAmount" class="add-asterisk">Price:</label><div class="form-section">
                        <div>
                                        <input id="priceType1" name="postAdForm.priceType" class="price-button" checked="checked" value="FIXED" type="radio"><label for="priceType1" class="radio-button-rd">
                                            <div class="inner-circle"></div>
                                        </label>

                                        <span class="radio-label">
                                            $ <input id="PriceAmount" name="postAdForm.priceAmount" class="price-input " data-max="99999999.99" data-dependent-change="required,disabled,focus,clear" data-dependent="true" data-dependent-on="#priceType1" data-type="price" value="" maxlength="11" req="true" type="text"></span>
                                    </div>

                                    <div id="PriceDropContainer" style="display: none;">
                                                <p>
                                                    <label data-feature-name="PriceDrop">
                                                        <input id="PriceDropInDetails" class="calculate-total" value="true" type="checkbox">
                                                        <span id="priceDrop-Label" class="reduced-title">
                                                            </span>
                                                        <span class="price" data-price="3.99">
                                                            7 days - $3.99</span>
                                                    </label>
                                                </p>
                                                <p>
                                                    Use of Price Drop will result in an implied ‘savings’ claim regarding your item.  You are responsible for all claims you may make in your ad, including any savings claims through the use of Price Drop.&nbsp;
                                                    <a href="https://help.kijiji.ca/helpdesk/basics/price-drop-feature" target="_blank" rel="noopener noreferrer">
                                                        Learn More</a>
                                                </p>
                                            </div>
                                        <label>
                                        <input id="priceType2" name="postAdForm.priceType" class="price-button" value="GIVE_AWAY" type="radio"><label for="priceType2" class="radio-button-rd">
                                            <div class="inner-circle"></div>
                                        </label>

                                        <span class="radio-label">Free</span>
                                    </label>
                                <label>
                                        <input id="priceType3" name="postAdForm.priceType" class="price-button" value="CONTACT" type="radio"><label for="priceType3" class="radio-button-rd">
                                            <div class="inner-circle"></div>
                                        </label>

                                        <span class="radio-label">Please Contact</span>
                                    </label>
                                <label>
                                        <input id="priceType4" name="postAdForm.priceType" class="price-button" value="SWAP_TRADE" type="radio"><label for="priceType4" class="radio-button-rd">
                                            <div class="inner-circle"></div>
                                        </label>

                                        <span class="radio-label">Swap / Trade</span>
                                    </label>
                                <div class="field-message add-clear" data-for="PriceAmount"></div>
                    </div>
                </li>
            <!-- forsaleby_s -->
    <a name="postAdForm.attributeMap[forsaleby_s]"></a>
        <li "="">
                    <!-- forsaleby_s -->
                    <label class="add-asterisk  " for="forsaleby_s">
    For Sale By<span class="colon">:</span>
    </label>

<div class="form-section">
    <label class="radio-button-content">
                                    <input id="forsaleby_s" name="postAdForm.attributeMap[forsaleby_s]" class=" forsaleby_s" req="req" value="ownr" type="radio"><label for="forsaleby_s" class="radio-button-rd">
                                        <div class="inner-circle"></div>
                                    </label>

                                    <span class="radio-label">
                                        Owner</span>
                                </label>
                        <label class="radio-button-content">
                                    <input id="forsaleby_s-1" name="postAdForm.attributeMap[forsaleby_s]" class=" forsaleby_s" req="req" value="delr" type="radio"><label for="forsaleby_s-1" class="radio-button-rd">
                                        <div class="inner-circle"></div>
                                    </label>

                                    <span class="radio-label">
                                        Business</span>
                                </label>
                        <div class="field-message add-clear hidden-for-ct" data-for="forsaleby_s"></div>

    </div>
</li>
            <!-- moreinfo_s -->
    <a name="postAdForm.attributeMap[moreinfo_s]"></a>
        <li "="">
                    <!-- moreinfo_s -->
                    <label class="add-asterisk  " for="moreinfo_s">
    More Info<span class="colon">:</span>
    </label>

<div class="form-section">
    <select id="moreinfo_s" name="postAdForm.attributeMap[moreinfo_s]" class="add-asterisk  " req="req"><option value="">- Select -</option>
                            <option value="art">Art</option>
                            <option value="collectible-toys-games">Collectible Toys &amp; Games</option>
                            <option value="pop-culture-collectibles">Pop Culture Collectibles</option>
                            <option value="sports-collectibles">Sports Collectibles</option>
                            <option value="vintage-antiques">Vintage, Antiques</option>
                            <option value="other">Other</option>
                            </select><div class="field-message add-clear hidden-for-ct" data-for="moreinfo_s"></div>

    </div>
</li>
            <li>
                <a name="postAdForm.title"></a>
                <label for="postad-title" class="add-asterisk">Ad Title:</label><div class="form-section">
                    <input id="postad-title" name="postAdForm.title" class="add-asterisk" req="req" value="" maxlength="64" type="text"><span class="field-message" data-for="postad-title"></span>

                    <div id="UrgentInline">
                            <p>
                                <label data-feature-name="Urgent">
                                    <input id="UrgentInDetails" class="calculate-total" value="true" type="checkbox">
                                    <label class="checkbox-label" for="UrgentInDetails"></label>
                                    <span class="urgent-title feature-name">
                                        URGENT</span>
                                    <span class="price" data-price="4.31">
                                        7 days - <span id="UrgentInlinePrice">$4.31</span>
                                    </span>
                                </label>
                            </p>
                            <p>Let others know you are looking for quick responses.&nbsp;<a href="https://help.kijiji.ca/helpdesk/basics/urgent-reduced-feature" target="_blank" data-helpdesk-btn="postad_pricing" data-helpdesk-article="LearnMoreUrgent" rel="noopener noreferrer">Learn More</a></p>
                            </div>

                        </div>
            </li>

            <li>
                <a name="postAdForm.description"></a>
                <label for="pstad-descrptn">Description:</label><div class="form-section">
                    <textarea id="pstad-descrptn" name="postAdForm.description" spellcheck="true" maxlength="61000" data-minlength="10" req="req"></textarea><span class="field-message" data-for="pstad-descrptn"></span>

                    </div>
            </li>

                <input id="pstad-loctnid" name="postAdForm.locationId" value="1700118" type="hidden">

            <li>
                        <a name="postAdForm.location"></a>
                        <label for="locationLevel0" class="add-asterisk">Location:</label><div class="form-section">
                            <select id="locationLevel0" name="locationLevel0" req="req" class="locationSelector ">
                                        <option value="1700118" selected="selected">
                                                    Prince Edward Island</option>
                                        </select>

                                    <div class="field-message" data-for="locationLevel0"></div>
                                    <p class="message">Please select your location or the one nearest you.</p>
                                </div>
                    </li>

                    <li>
                            <label for="locationLevel1" class="add-asterisk">Sub Area:</label>

                            <div class="form-section">
                                <select id="locationLevel1" name="postAdForm.locationSubArea" class="locationSelector">
                                    <option value="">----------</option>
                                        <option value="1700119">
                                                    Charlottetown</option>
                                        <option value="1700120">
                                                    Summerside</option>
                                        </select>

                                <div class="field-message" data-for="locationLevel1"></div>

                                <p class="message">
                                    Please select your subarea or the one nearest you. Your Ad will be posted on both the site for that location and Kijiji Prince Edward Island.</p>
                            </div>
                        </li>
                    </ul>
        </div>

    <div class="container-info">
        <h2>
            <div class="number">2</div>Location</h2>
        <ul class="post-ad-layout location">
            <li class="postal-code">
                        <a name="postAdForm.postalCode"></a>
                        <label for="PostalCode" class="add-asterisk">Postal Code:</label><div class="form-section">
                            <div class="container-postal-code">
                                <input id="PostalCode" name="postAdForm.postalCode" class="postal-code" req="req" value="" maxlength="7" type="text"><span class="buyer-see">Buyers See:<input id="PostalCodeCity" disabled="disabled" value="" type="text"></span>
                                <span class="field-message" data-for="PostalCode"></span>
                                </div>

                            <p class="message">Your Postal code is required to help others find your ad</p>
                        </div>
                    </li>

                    <li class="street-address">
                        <a name="postAdForm.mapAddress"></a>
                        <label for="pstad-map-address">Street Address<span class="colon">:</span>
                            <span class="optional-text">(optional)</span>
                        </label><div class="form-section">
                            <input id="pstad-map-address" name="postAdForm.mapAddress" placeholder="|" value="" autocomplete="off" type="text"><p class="message">Adding a street address is optional, but can increase the visibility of your ad.&nbsp;<a href="https://help.kijiji.ca/helpdesk/basics/why-postal-codes-are-mandatory" data-helpdesk-btn="learnmore" data-helpdesk-article="PostalCode" target="_blank" rel="noopener noreferrer">Learn More</a></p>
                            <span class="field-message" data-for="pstad-map-address"></span>
                        </div>
                    </li>
                </ul>
    </div>
    <div class="container-info">
        <h2>
            <div class="number">3</div>Media</h2>
        <ul class="post-ad-layout">
                <li class="jsonly">
                <div id="MediaImageUpload" class="clearfix form-section placeholders">
                    <p class="images-title">Add at least one photo to complete your ad.</p>
                    <div class="images-content">
                        <h3>Add photos to attract interest to your ad</h3>
                        <div class="images-content-secondary">
                            <p>Include pictures with different angles and details. You can upload a maximum of <span id="MaxImages">10</span> photos, that are at least 300px wide or tall (we recommend at least 1000px).</p>
                            <p>Drag and drop to change the order of your pictures.</p>
                        </div>
                    </div>
                    <ol id="MediaUploadedImages" class="ui-sortable"><li class="pic-placeholder"><div class="image-area" style="background-image: url(https://ca.classistatic.com/static/V/5783.4/img/placeHolder/generic.svg);"></div><div class="image-toolbar"></div></li><li class="pic-placeholder"><div class="image-area" style="background-image: url(https://ca.classistatic.com/static/V/5783.4/img/placeHolder/generic.svg);"></div><div class="image-toolbar"></div></li><li class="pic-placeholder"><div class="image-area" style="background-image: url(https://ca.classistatic.com/static/V/5783.4/img/placeHolder/generic.svg);"></div><div class="image-toolbar"></div></li><li class="pic-placeholder"><div class="image-area" style="background-image: url(https://ca.classistatic.com/static/V/5783.4/img/placeHolder/generic.svg);"></div><div class="image-toolbar"></div></li><li class="pic-placeholder"><div class="image-area" style="background-image: url(https://ca.classistatic.com/static/V/5783.4/img/placeHolder/generic.svg);"></div><div class="image-toolbar"></div></li><li class="pic-placeholder"><div class="image-area" style="background-image: url(https://ca.classistatic.com/static/V/5783.4/img/placeHolder/generic.svg);"></div><div class="image-toolbar"></div></li><li class="pic-placeholder"><div class="image-area" style="background-image: url(https://ca.classistatic.com/static/V/5783.4/img/placeHolder/generic.svg);"></div><div class="image-toolbar"></div></li><li class="pic-placeholder"><div class="image-area" style="background-image: url(https://ca.classistatic.com/static/V/5783.4/img/placeHolder/generic.svg);"></div><div class="image-toolbar"></div></li><li class="pic-placeholder"><div class="image-area" style="background-image: url(https://ca.classistatic.com/static/V/5783.4/img/placeHolder/generic.svg);"></div><div class="image-toolbar"></div></li><li class="pic-placeholder"><div class="image-area" style="background-image: url(https://ca.classistatic.com/static/V/5783.4/img/placeHolder/generic.svg);"></div><div class="image-toolbar"></div></li></ol>

                    <span class="field-message" data-for="FileUploadInput"></span>

                    <div id="FileInputWrapper" class="file-input-wrapper">
                        <input name="file" class="fileErrorBox" type="hidden">

                        <div class="imageUploadButtonWrapper" style="position: relative;">
                            <button id="ImageUploadButton" type="button" class="button-update-cancel short file-upload-button" style="position: relative; z-index: 1;">
                                Select Images</button>
                        <div id="html5_1c4934sl114s21thq1nsf1ibfdvi3_container" class="moxie-shim moxie-shim-html5" style="position: absolute; top: 0px; left: 0px; width: 150px; height: 45px; overflow: hidden; z-index: 0;"><input id="html5_1c4934sl114s21thq1nsf1ibfdvi3" style="font-size: 999px; opacity: 0; position: absolute; top: 0px; left: 0px; width: 100%; height: 100%;" multiple="" accept="image/jpeg,image/png,image/gif,image/bmp" type="file"></div></div>
                    </div>
                </div>
            </li>

                <li>
                    <label for="YoutubeURL">YouTube Video<span class="colon">:</span>
                        <span class="optional-text">(optional)</span>
                    </label><div class="form-section">
                        <input id="YoutubeURL" name="postAdForm.youtubeVideoURL" value="" autocomplete="off" type="text"><span class="field-message" data-for="YoutubeURL"></span>
                        <p class="message">Add a YouTube video to your ad.</p>

                        <p class="example">Example: http://www.youtube.com/watch?v=&lt;your video id&gt;</p>
                    </div>
                </li>
            <div id="WebsiteUrl">
                <li>
                    <label for="PostWebsiteURL">Website URL:</label>

                    <div class="form-section">
                        <label id="WebsiteUrlInline">
                                <input id="PostWebsite" class="calculate-total" type="checkbox">
                                <label class="checkbox-label" for="PostWebsite"></label>
                                <span>
                                    Link to your website - <span id="WebsiteUrlPrice">$5.99</span>
                                </span>
                            </label>
                        <input id="PostWebsiteURL" name="featuresForm.websiteUrl" class="websiteUrlSync" disabled="disabled" value="" type="text"><div class="field-message" data-for="PostWebsiteURL"></div>

                        </div>
                </li>
            </div>
        </ul>
    </div>

    <div class="container-info">
    <h2>
        <div class="number">4</div>Contact Information<div class="add-asterisk"> = mandatory fields</div>
    </h2>
    <ul class="post-ad-layout">

        <li>
                <a name="postAdForm.phoneNumber"></a>
                <label for="postAdForm.phoneNumber">Phone Number<span class="colon">:</span>
                    <span class="optional-text">(optional)</span>
                </label><div class="form-section">
                    <input id="PhoneNumber" name="postAdForm.phoneNumber" x-autocompletetype="phone-full" value="" maxlength="40" type="text"><p class="message">Your phone number will show up on your Ad.</p>
                    <span class="field-message" data-for="PhoneNumber"></span>

                    </div>
            </li>
        <li>
                    <a id="email" name="postAdForm.email"></a>
                    <label for="pstad-email" class="add-asterisk">Email:</label><div class="form-section">
                        <input id="pstad-email" name="postAdForm.email" data-type="email" x-autocompletetype="email" req="req" disabled="disabled" value="lakhvinder.3ginfo@gmail.com" type="text"><span class="field-message" data-for="pstad-email"></span>
                        <p class="message">Your email address will not be shared with others.</p>
                    </div>
                </li>
            </ul>
</div><div id="AlacarteFeatures" class="container-info contains-insets contains-inset-right">
        <div class="inset-right">
            <table id="RecommendedFeatureContainer">
    <tbody><tr>
        <td>
            <div id="RecommendedFeatureGallery" class="cycle-slideshow" data-cycle-prev="#CtaPrevRecommendedFeature" data-cycle-next="#CtaNextRecommendedFeature" data-cycle-pager="#RecommendedFeatureGalleryPager" data-cycle-log="âfalse&quot;" data-cycle-timeout="0" data-cycle-center-vert="true" data-cycle-slides=".recommended-feature" style="position: relative;"><div class="recommended-feature cycle-slide cycle-sentinel" style="position: static; top: 0px; left: 0px; z-index: 100; opacity: 1; display: block; visibility: hidden;">
                        <div class="gallery-title-container" style="visibility: hidden;">
                            <p class="gallery-title" style="visibility: hidden;">Recommended Feature</p>
                                </div>

                        <div class="gallery-content" style="visibility: hidden;">
                            <p class="gallery-header" style="visibility: hidden;">Add a Top Ad</p>

                            <div class="promote-icon top large" style="visibility: hidden;"></div>

                            <p class="gallery-description" style="visibility: hidden;">Top ads are seen up to 9x more than others.<sup style="visibility: hidden;">*</sup></p>

                            <a href="javascript: void(0);" data-target="Top" class="promote-add-to-cart" style="visibility: hidden;">
                                Add to cart</a>
                        </div>

                        <p class="top-ad-disclaimer" style="visibility: hidden;">
                                <sup style="visibility: hidden;">*</sup> Compared to a non-featured ad. Based on the average increase in views across all categories. We provide no guarantee regarding the number of impressions, views and/or replies your ad will actually receive.</p>
                        </div>

                    <a title="Previous" href="javascript:void(0);" id="CtaPrevRecommendedFeature" class="arrow-prev-grey hide-text">Previous</a>
                    <a title="Next" href="javascript:void(0);" id="CtaNextRecommendedFeature" class="arrow-next-grey hide-text">Next</a>
                    
                
                
                
                <div class="recommended-feature cycle-slide cycle-slide-active" style="position: absolute; top: 0px; left: 0px; z-index: 100; opacity: 1; display: block; visibility: visible;">
                        <div class="gallery-title-container">
                            <p class="gallery-title">Recommended Feature</p>
                                </div>

                        <div class="gallery-content">
                            <p class="gallery-header">Add a Top Ad</p>

                            <div class="promote-icon top large"></div>

                            <p class="gallery-description">Top ads are seen up to 9x more than others.<sup>*</sup></p>

                            <a href="javascript: void(0);" data-target="Top" class="promote-add-to-cart">
                                Add to cart</a>
                        </div>

                        <p class="top-ad-disclaimer">
                                <sup>*</sup> Compared to a non-featured ad. Based on the average increase in views across all categories. We provide no guarantee regarding the number of impressions, views and/or replies your ad will actually receive.</p>
                        </div><div class="recommended-feature cycle-slide" style="position: absolute; top: 0px; left: 0px; z-index: 99; visibility: hidden;">
                        <div class="gallery-title-container">
                            
                                    &nbsp;
                                </div>

                        <div class="gallery-content">
                            <p class="gallery-header">Add a Homepage Gallery Ad</p>

                            <div class="promote-icon hpg large"></div>

                            <p class="gallery-description">Get on average 32,000 impressions/week with a prime position on our homepage<sup>*</sup></p>

                            <a href="javascript: void(0);" data-target="Hpg" class="promote-add-to-cart">
                                Add to cart</a>
                        </div>

                        <p class="top-ad-disclaimer">
                                <sup>*</sup> Based on the average number of impressions on the homepage across all locations. We provide no guarantee regarding the number of impressions, views, and/or replies your ad will actually receive.</p>
                        </div><div class="recommended-feature cycle-slide" style="position: absolute; top: 0px; left: 0px; z-index: 97; visibility: hidden;">
                        <div class="gallery-title-container">
                            
                                    &nbsp;
                                </div>

                        <div class="gallery-content">
                            <p class="gallery-header">Add an Urgent Ad</p>

                            <div class="promote-icon urgent large"></div>

                            <p class="gallery-description">Let others know you are looking for quick responses.</p>

                            <a href="javascript: void(0);" data-target="Urgent" class="promote-add-to-cart">
                                Add to cart</a>
                        </div>

                        </div><div class="recommended-feature cycle-slide" style="position: absolute; top: 0px; left: 0px; z-index: 96; visibility: hidden;">
                        <div class="gallery-title-container">
                            
                                    &nbsp;
                                </div>

                        <div class="gallery-content">
                            <p class="gallery-header">Add Highlight <br> to Your Ad</p>

                            <div class="promote-icon high large"></div>

                            <p class="gallery-description">Highlight your ad to gain visibility and stand out from the <br> crowd.</p>

                            <a href="javascript: void(0);" data-target="High" class="promote-add-to-cart">
                                Add to cart</a>
                        </div>

                        </div></div>
        </td>
    </tr>
</tbody></table>
</div>

        <div class="inset-main-left">
     <h2>Promote My Ad</h2>

                <table class="promotions">
                    <tbody><tr>
                        <th class="left">Features</th>
                        <th class="length">Length</th>
                        <th class="right">Total</th>
                    </tr>

                    <tr class="select-feature " data-feature-name="Top">
                                <td class="left" colspan="2">
                                            <input id="TopAdInPromoteMyAds" name="featuresForm.topAd" value="true" class="price calculate-total" data-price="3.23" data-hasqtip="6" type="checkbox">

                                            <label class="checkbox-label" for="TopAdInPromoteMyAds"></label>

                                            <div class="promote-icon top"></div>

                                            <div class="feature-content">
                                                <div class="feature-header">
                                                        <p class="feature-title feature-name">Top Ad</p>

                                                        <span class="tooltip-trigger icon" data-content="ToolTiptop" data-hasqtip="0">?</span>

                                                            <span class="tooltip-content" id="ToolTiptop">
                                                                Keep your ad at the top of its category.
                                                                    &nbsp;
                                                                    <a href="https://help.kijiji.ca/performance/TopAd" target="_blank" data-helpdesk-btn="hover" data-helpdesk-article="LearnMoreTopAd" rel="noopener noreferrer">
                                                                                Learn&nbsp;More</a>
                                                                        </span>
                                                        </div>


                                                    <div class="days select-duration">
                                                                    <select name="featuresForm.topAdDuration" class="day-selector calculate-total">
                                                                        <option value="3">3 days</option>
                                                                    <option value="7" selected="selected">7 days</option>
                                                                    <option value="30">30 days</option>
                                                                    </select>
                                                                    </div>
                                                                </div>
                                            
                                </td>

                                    <td class="right">
                                            <div class="price" data-price="5.99">
                                                    $5.99</div>
                                                <input class="counters" value="5.99" type="hidden">
                                            </td>
                                            </tr>
                            <tr class="select-feature " data-feature-name="High">
                                <td class="left" colspan="2">
                                            <input id="HighlightInPromoteMyAds" name="featuresForm.highlight" value="true" class="price calculate-total" data-price="1.99" data-hasqtip="7" type="checkbox">

                                            <label class="checkbox-label" for="HighlightInPromoteMyAds"></label>

                                            <div class="promote-icon high"></div>

                                            <div class="feature-content">
                                                <div class="feature-header">
                                                        <p class="feature-title feature-name">Highlight Ad</p>

                                                        <span class="tooltip-trigger icon" data-content="ToolTiphigh" data-hasqtip="1">?</span>

                                                            <span class="tooltip-content" id="ToolTiphigh">
                                                                Make every ad shine.
                                                                    &nbsp;
                                                                    <a href="https://help.kijiji.ca/performance/Highlight" target="_blank" data-helpdesk-btn="hover" data-helpdesk-article="LearnMoreHighlight" rel="noopener noreferrer">
                                                                                Learn&nbsp;More</a>
                                                                        </span>
                                                        </div>


                                                    <div class="days">7 days</div>
                                                            </div>
                                            
                                </td>

                                    <td class="right">
                                                <div class="price" data-price="1.99">$1.99</div>
                                                <input class="counters" value="1.99" type="hidden">
                                            </td>
                                        </tr>
                            <tr class="select-feature " data-feature-name="Urgent">
                                <td class="left" colspan="2">
                                            <input id="UrgentInPromoteMyAds" name="featuresForm.urgent" value="true" class="price calculate-total" data-price="4.31" data-hasqtip="8" type="checkbox">

                                            <label class="checkbox-label" for="UrgentInPromoteMyAds"></label>

                                            <div class="promote-icon urgent"></div>

                                            <div class="feature-content">
                                                <div class="feature-header">
                                                        <p class="feature-title feature-name">Urgent Ad</p>

                                                        <span class="tooltip-trigger icon" data-content="ToolTipurgent" data-hasqtip="2">?</span>

                                                            <span class="tooltip-content" id="ToolTipurgent">
                                                                The right feature to sell fast.
                                                                    &nbsp;
                                                                    <a href="https://help.kijiji.ca/performance/Urgent" target="_blank" data-helpdesk-btn="hover" data-helpdesk-article="LearnMoreUrgent" rel="noopener noreferrer">
                                                                                Learn&nbsp;More</a>
                                                                        </span>
                                                        </div>


                                                    <div class="days">7 days</div>
                                                            </div>
                                            
                                </td>

                                    <td class="right">
                                                <div class="price" data-price="4.31">$4.31</div>
                                                <input class="counters" value="4.31" type="hidden">
                                            </td>
                                        </tr>
                            <tr class="select-feature " data-feature-name="Hpg">
                                <td class="left" colspan="2">
                                            <input id="HomepageGalleryInPromoteMyAds" name="featuresForm.homepageGallery" value="true" class="price calculate-total" data-price="5.39" data-hasqtip="9" type="checkbox">

                                            <label class="checkbox-label" for="HomepageGalleryInPromoteMyAds"></label>

                                            <div class="promote-icon hpg"></div>

                                            <div class="feature-content">
                                                <div class="feature-header">
                                                        <p class="feature-title feature-name">Homepage Gallery</p>

                                                        <span class="tooltip-trigger icon" data-content="ToolTiphpg" data-hasqtip="3">?</span>

                                                            <span class="tooltip-content" id="ToolTiphpg">
                                                                Get maximum exposure on the Kijiji homepage.
                                                                    &nbsp;
                                                                    <a href="https://help.kijiji.ca/performance/Gallery" target="_blank" data-helpdesk-btn="hover" data-helpdesk-article="LearnMoreHPG" rel="noopener noreferrer">
                                                                                Learn&nbsp;More</a>
                                                                        </span>
                                                        </div>


                                                    <div class="days">7 days</div>
                                                            </div>
                                            
                                </td>

                                    <td class="right">
                                                <div class="price" data-price="5.39">$5.39</div>
                                                <input class="counters" value="5.39" type="hidden">
                                            </td>
                                        </tr>
                            <tr class="select-feature price-drop-feature" data-feature-name="priceDrop" style="display: none;">
                                <td class="left" colspan="2">
                                            <input id="PriceDropFeature" name="featuresForm.priceDrop" value="true" class="price calculate-total" data-price="3.99" data-hasqtip="10" type="checkbox">

                                            <label class="checkbox-label" for="PriceDropFeature"></label>

                                            <div class="promote-icon price-drop"></div>

                                            <div class="feature-content">
                                                <div class="feature-header">
                                                        <p class="feature-title feature-name">Price Drop</p>

                                                        <span class="tooltip-trigger icon" data-content="ToolTipprice-drop" data-hasqtip="4">?</span>

                                                            <span class="tooltip-content" id="ToolTipprice-drop">
                                                                Use of Price Drop will result in an implied ‘savings’ claim regarding your item.  You are responsible for all claims you may make in your ad, including any savings claims through the use of Price Drop.
                                                                    &nbsp;
                                                                    <a href="https://help.kijiji.ca/helpdesk/basics/price-drop-feature" target="_blank" data-helpdesk-btn="hover" data-helpdesk-article="LearnMorePriceDrop" rel="noopener noreferrer">
                                                                                Learn&nbsp;More</a>
                                                                        </span>
                                                        </div>


                                                    <div class="days">7 days</div>
                                                            </div>
                                            
                                </td>

                                    <td class="right">
                                                <div class="price" data-price="3.99">$3.99</div>
                                                <input class="counters" value="3.99" type="hidden">
                                            </td>
                                        </tr>
                            <tr class="select-feature " data-feature-name="Url">
                                <td class="left" colspan="2">
                                            <input id="WebsiteInPromoteMyAds" name="featuresForm.websiteFeature" value="true" class="price calculate-total" data-price="5.99" data-hasqtip="11" type="checkbox">

                                            <label class="checkbox-label" for="WebsiteInPromoteMyAds"></label>

                                            <div class="promote-icon url"></div>

                                            <div class="feature-content">
                                                <div class="feature-header">
                                                        <p class="feature-title feature-name">Website URL</p>

                                                        <span class="tooltip-trigger icon" data-content="ToolTipurl" data-hasqtip="5">?</span>

                                                            <span class="tooltip-content" id="ToolTipurl">
                                                                Drive people to your website.
                                                                    &nbsp;
                                                                    <a href="https://help.kijiji.ca/performance/URL" target="_blank" data-helpdesk-btn="hover" data-helpdesk-article="LearnMoreURL" rel="noopener noreferrer">
                                                                                Learn&nbsp;More</a>
                                                                        </span>
                                                        </div>


                                                    <div class="days">60 days</div>
                                                            </div>
                                            
                                </td>

                                    <td class="right">
                                                <div class="price" data-price="5.99">$5.99</div>
                                                <input class="counters" value="5.99" type="hidden">
                                            </td>
                                        </tr>
                            <tr class="total">
                        <td colspan="3">
                            Total Price:&nbsp;
                            <span id="TotalPrice">$0.00</span>
                        </td>
                    </tr>
                </tbody></table>

                </div> <div class="clear"></div>
            </div>
        <p class="small-print">
                        By posting your ad, you are agreeing to our <a href="https://help.kijiji.ca/helpdesk/policies/kijiji-terms-of-use" target="_blank" data-helpdesk-article="TermsOfUse" rel="noopener noreferrer">terms of use</a>, <a href="https://help.kijiji.ca/helpdesk/policies/kijiji-privacy-policy" target="_blank" data-helpdesk-article="PrivacyPolicy" rel="noopener noreferrer">privacy policy</a> and <a href="https://help.kijiji.ca/helpdesk/policies/" target="_blank" data-helpdesk-article="TermsOfUse" rel="noopener noreferrer">site policies</a>.<br>Please do not post duplicate ads. Use 'Promote My Ad' above to gain more replies.</p>
                <div class="post-ad-buttons">
            <input name="submitType" value="saveAndCheckout" type="hidden">
                    <button class="button-task post-ad-button" type="submit" name="saveAndCheckout">
                        Post Your Ad</button>
                <button class="button-task secondary post-ad-button" id="PostAdPreview">Preview</button>
            </div>
    </div>
</form>
   <!-- content
   ================================================== -->
   <section id="content-wrap" class="blog-single">
   	<div class="row">
   		<div class="col-twelve">

   			<article class="format-standard">

   				<div class="content-media">
					<div class="post-thumb">
						<img src="{{ $post->image }}">
					</div>
				</div>

				<div class="primary-content">

					<h1 class="page-title">{{ $post->title }}</h1>

					<ul class="entry-meta">
						<li class="date">{{ ucfirst (utf8_encode ($post->created_at->formatLocalized('%A %d %B %Y'))) }}</li>
                        <li class="cat">
                            @foreach ($post->categories as $category)
                                <a href="{{ route('category', [$category->slug]) }}">{{ $category->title }}</a>
                            @endforeach
                        </li>
					</ul>

					{!! $post->body !!}

                    <!-- Tags -->
					@if ($post->tags->count())
						<p class="tags">
							<span>@lang('Tagged in') :</span>
							@foreach($post->tags as $tag)
								<a href="{{ route('posts.tag', [$tag->id]) }}">{{ $tag->tag }}</a>
							@endforeach
						</p>
					@endif

					<div class="author-profile">
						<img src="{{ Gravatar::get($post->user->email) }}" alt="">
						<div class="about">
							<h4>{{ $post->user->name }}</h4>
						</div>
					</div> <!-- end author-profile -->

				</div> <!-- end entry-primary -->

				<div class="pagenav group">
					@if ($post->previous)
						<div class="prev-nav">
							<a href="{{ url('posts/' . $post->previous->slug) }}" rel="prev">
								<span>@lang('Previous')</span>
								{{ $post->previous->title }}
							</a>
						</div>
					@endif
					@if ($post->next)
						<div class="next-nav">
							<a href="{{ url('posts/' . $post->next->slug) }}" rel="next">
								<span>@lang('Next')</span>
								{{ $post->next->title }}
							</a>
						</div>
					@endif
				</div>

			</article>

		</div> <!-- end col-twelve -->
   	</div> <!-- end row -->

	<div class="comments-wrap">
		<div id="comments" class="row">
            @if (session('warning'))
                @component('front.components.alert')
                    @slot('type')
                        notice
                    @endslot
                    {!! session('warning') !!}
                @endcomponent
            @endif
            <h3>{{ $post->valid_comments_count }} {{ trans_choice(__('comment|comments'), $post->valid_comments_count) }}</h3>

			<!-- commentlist -->
			@if ($post->valid_comments_count)
                @php
                    $level = 0;
                @endphp
				<ol class="commentlist">
					@include('front/comments/comments', ['comments' => $post->parentComments])
				</ol>
                @if ($post->parent_comments_count > config('app.numberParentComments'))
                    <p id="morebutton" class="text-center">
                        <a id="nextcomments" href="{{ route('posts.comments', [$post->id, 1]) }}" class="button">@lang('More comments')</a>
                    </p>
                        <p id="moreicon" class="text-center hide">
                        <span class="fa fa-spinner fa-pulse fa-3x fa-fw"></span>
                    </p>
                @endif
			@endif

			<!-- respond -->
			<div class="respond">

			    <h3>@lang('Leave a Comment')</h3>
                @if (Auth::check())
    				<form method="post" action="{{ route('posts.comments.store', [$post->id]) }}">
                        {{ csrf_field() }}
    					<div class="message form-field">
                            @if ($errors->has('message'))
                                @component('front.components.error')
                                    {{ $errors->first('message') }}
                                @endcomponent
                            @endif
    						<textarea name="message" id="message" class="full-width" placeholder="@lang('Your message')" value="{{ old('message') }}" required></textarea>
    					</div>
    					<button type="submit" class="submit button-primary">@lang('Submit')</button>
    				</form>
                @else
                    <em>@lang('You must be logged to add a comment !')</em>
                @endif

			</div> <!-- Respond End -->

		</div> <!-- end row comments -->
	</div> <!-- end comments-wrap -->

   </section> <!-- end content -->

@endsection

@section('scripts')
    @if (auth()->check())
        <script src="//cdn.jsdelivr.net/sweetalert2/6.3.8/sweetalert2.min.js"></script>
        <script>

            var post = (function () {

                var onReady = function () {
                    $('body').on('click', 'a.deletecomment', deleteComment)
                        .on('click', 'a.editcomment', editComment)
                        .on('click', '.btnescape', escapeComment)
                        .on('submit', '.comment-form', submitComment)
                        .on('click', 'a.reply', replyCreation)
                        .on('click', '.btnescapereply', escapeReply)
                        .on('submit', '.reply-form', submitReply)
                }

                var toggleEditControls = function (id) {
                    $('#comment-edit' + id).toggle()
                    $('#comment-body' + id).toggle('slow')
                    $('#comment-form' + id).toggle('slow')
                }

                // Delete comment
                var deleteComment = function (event) {
                    event.preventDefault()
                    var that = $(this)
                    swal({
                        title: "{!! __('Really delete this comment ?') !!}",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "{!! __('Yes') !!}",
                        cancelButtonText: "{!! __('No') !!}"
                    }).then(function () {
                        that.next('form').submit()
                    })
                }

                // Set comment edition
                var editComment = function (event) {
                    event.preventDefault()
                    var i = $(this).attr('id').substring(12);
                    $('form.comment-form textarea#message' + i).val($('#comment-body' + i).text())
                    toggleEditControls(i)
                }

                // Escape comment edition
                var escapeComment = function (event) {
                    event.preventDefault()
                    var i = $(this).attr('id').substring(14)
                    toggleEditControls(i)
                    $('form.comment-form textarea#message' + i).prev().text('')
                }

                // Submit comment
                var submitComment = function (event) {
                    event.preventDefault();
                    $.ajax({
                        method: 'put',
                        url: $(this).attr('action'),
                        data: $(this).serialize()
                    })
                        .done(function (data) {
                            $('#comment-body' + data.id).text(data.message)
                            toggleEditControls(data.id)
                        })
                        .fail(function(data) {
                            var errors = data.responseJSON
                            $.each(errors, function(index, value) {
                                value = value[0].replace(index, '@lang('message')')
                                $('form.comment-form textarea[name="' + index + '"]').prev().text(value)
                            });
                        });
                }

                // Set reply creation
                var replyCreation = function (event) {
                    event.preventDefault()
                    var i = $(this).attr('id').substring(12)
                    $('form.reply-form textarea#message' + i).val('')
                    $('#reply-form' + i).toggle('slow')
                }

                // Escape reply creation
                var escapeReply = function (event) {
                    event.preventDefault()
                    var i = $(this).attr('id').substring(12)
                    $('#reply-form' + i).toggle('slow')
                }

                // Submit reply
                var submitReply = function (event) {
                    event.preventDefault()
                    $.ajax({
                        method: 'post',
                        url: $(this).attr('action'),
                        data: $(this).serialize()
                    })
                        .done(function (data) {
                            document.location.reload(true)
                        })
                        .fail(function(data) {
                            var errors = data.responseJSON
                            $.each(errors, function(index, value) {
                                value = value[0].replace(index, '@lang('message')')
                                $('form.reply-form textarea[name="' + index + '"]').prev().text(value)
                            });
                        });
                }

                return {
                    onReady: onReady
                }

            })()

            $(document).ready(post.onReady)

        </script>
    @endif

    <script>
        $(function() {
            // Get next comments
            $('#nextcomments').click (function(event) {
                event.preventDefault()
                $('#morebutton').hide()
                $('#moreicon').show()
                $.get($(this).attr('href'))
                .done(function(data) {
                    $('ol.commentlist').append(data.html)
                    if(data.href !== 'none') {
                        $('#nextcomments').attr('href', data.href)
                        $('#morebutton').show()
                    }
                    $('#moreicon').hide()
                })
            })
        })
    </script>
@endsection
