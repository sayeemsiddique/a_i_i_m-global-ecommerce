@php
    $category_array = [];
    $brand_array = [];
    $varient_array = [];
    if(isset($_GET['c'])) {
        $category_array = $_GET['c'];
    }
    if(isset($_GET['b'])) {
        $brand_array = $_GET['b'];
    }
    if(isset($_GET['v'])) {
        $varient_array = $_GET['v'];
    }

    $product_min_price_from = $product_min_price;
    $product_max_price_to = $product_max_price;

    if (isset($_GET['range']) and $_GET['range'] != '') {
        $range_data = explode('%3B', $_GET['range']);

        $product_min_price_from = explode(";",$range_data[0])[0];
        $product_max_price_to = explode(";",$range_data[0])[1];

    }

    
    
@endphp
<form id="sidebar_form" action="" method="get">
    <input type="hidden" name="per_page" value="@if(isset($_GET['per_page']) and $_GET['per_page'] == 100) {{$_GET['per_page']}} @endif">
    <input type="hidden" name="sort_option" value="@if(isset($_GET['sort_option']) and $_GET['sort_option'] == 100) {{$_GET['sort_option']}} @endif">
    <input type="hidden" name="searchProduct" value="@if(isset($_GET['searchProduct'])) {{$_GET['searchProduct']}} @endif">
    
    <div class="mb-8 border border-width-2 border-color-3 borders-radius-6">
        <!-- List -->
        <ul id="sidebarNav" class="list-unstyled mb-0 sidebar-navbar">
            <li>
                <a class="dropdown-toggle dropdown-toggle-collapse dropdown-title" href="javascript:;" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="sidebarNav1Collapse" data-target="#sidebarNav1Collapse">
                    Show All Categories
                </a>
    
                {{-- <div id="sidebarNav1Collapse" class="collapse show" data-parent="#sidebarNav"> --}}
                    <ul id="sidebarNav1" class="list-unstyled dropdown-list">
                        <!-- Menu List -->
                        <li>
                            @foreach ($main_categories as $categories)
                                <a class="dropdown-item" href="#">
                                    <label>
                                        <input name="c[]" @if (in_array($categories->id,$category_array))
                                            checked
                                        @endif value="{{$categories->id}}" type="checkbox">
                                        {{$categories->name}}<span class="text-gray-25 font-size-12 font-weight-normal"> ({{$categories->sell_products_count ?? 0}})</span>
                                    </label>
                                </a>
                                @if (count($categories->childTreeInfo) > 0)
                                @foreach ($categories->childTreeInfo as $child_item)
                                    <a class="dropdown-item" href="#">
                                        <label style="margin-left: 15px;">
                                              <input @if (in_array($child_item->id,$category_array))
                                              checked
                                          @endif name="c[]" value="{{$child_item->id}}" type="checkbox">
                                            {{$child_item->name}}<span class="text-gray-25 font-size-12 font-weight-normal"> ({{$child_item->child_sell_products_count ?? 0}})</span>
                                        </label>
                                    </a>
                                @endforeach
                                
                                @endif
                                
                            @endforeach
                            
                        </li>
                        
                        <!-- End Menu List -->
                    </ul>
                {{-- </div> --}}
            </li>
            
        </ul>
        <!-- End List -->
    </div>
    <div class="mb-6">
        <div class="border-bottom border-color-1 mb-5">
            <h3 class="section-title section-title__sm mb-0 pb-2 font-size-18">Filters</h3>
        </div>
        <div class="border-bottom pb-4 mb-4">
            <h4 class="font-size-14 mb-3 font-weight-bold">Brands</h4>
    
            <!-- Checkboxes -->
            
                
            @foreach ($brands as $brand)
                <div class="form-group d-flex align-items-center justify-content-between mb-2 pb-1">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" value="{{$brand->id}}" @if (in_array($brand->id,$brand_array))
                            checked
                        @endif name="b[]" class="custom-control-input" id="brandAdidas{{$brand->id}}">
                        <label class="custom-control-label" for="brandAdidas{{$brand->id}}">{{$brand->name}}
                            <span class="text-gray-25 font-size-12 font-weight-normal"> ({{$brand->brand_products_count}})</span>
                        </label>
                    </div>
                </div>
            @endforeach
                
            
        </div>
        <div class="border-bottom pb-4 mb-4">
            
    
            <!-- Checkboxes -->
            @foreach ($varient_datas as $varient_data)
                <h4 class="font-size-14 mb-3 font-weight-bold">{{$varient_data->name}}</h4>
    
                @foreach ($varient_data->varientValues as $varientData)
                    <div class="form-group d-flex align-items-center justify-content-between mb-2 pb-1">
                        <div class="custom-control custom-checkbox">
                            <input name="v[]" value="{{$varientData->id}}" @if (in_array($varientData->id, $varient_array))
                                checked
                            @endif type="checkbox" class="custom-control-input" id="categoryTshirt{{$varientData->id}}">
                            <label class="custom-control-label" for="categoryTshirt{{$varientData->id}}">{{$varientData->value}} <span class="text-gray-25 font-size-12 font-weight-normal"></span></label>
                        </div>
                    </div>
                @endforeach
            @endforeach
            
            
           
        </div>
        <div class="range-slider">
            <h4 class="font-size-14 mb-3 font-weight-bold">Price</h4>
            <!-- Range Slider -->
            <input name="range" class="js-range-slider" type="text"
            data-extra-classes="u-range-slider u-range-slider-indicator u-range-slider-grid"
            data-type="double"
            data-grid="false"
            data-hide-from-to="true"
            data-prefix="$"
            data-min="{{$product_min_price}}"
            data-max="{{$product_max_price}}"
            data-from="{{$product_min_price_from}}"
            data-to="{{$product_max_price_to}}"
            data-result-min="#rangeSliderExample3MinResult"
            data-result-max="#rangeSliderExample3MaxResult">
            <!-- End Range Slider -->
            <div class="mt-1 text-gray-111 d-flex mb-4">
                <span class="mr-0dot5">Price: </span>
                <span>৳</span>
                <span id="rangeSliderExample3MinResult" class=""></span>
                <span class="mx-0dot5"> — </span>
                <span>৳</span>
                <span id="rangeSliderExample3MaxResult" class=""></span>
            </div>
            <button type="submit" class="btn px-4 btn-primary-dark-w py-2 rounded-lg">Filter</button>
        </div>
    </div>
</form>