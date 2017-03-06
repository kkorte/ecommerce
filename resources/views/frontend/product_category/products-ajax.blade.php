<div class="row">

    <div class="show-for-large small-12 medium-12 large-3 columns">
        <div class="category-sidebar">
            @if ($childrenProductCategories)
            <ul class="category-navigation">
                @foreach ($childrenProductCategories as $children)
                @if($category->slug == $children->slug)
                <a href="/{{ $children['slug'] }}" class="current" title="ga naar {{ $children['title'] }}">
                    <li>{{ $children['title'] }}</li>
                </a>
                @else 
                <a href="/{{ $children->slug }}" title="ga naar {{ $children->title }}">
                    <li>{{ $children->title }}</li>
                </a>
                @endif
                @endforeach
            </ul>
            @endif
        </div>

        @if($extraFilterFields || $filterCombinations)
        <div class="filters">
            <h5>Filters</h5>

            @if($extraFilterFields)

            {!! Form::open(array('route' => array('product.category.ajax', $category->slug), 'class' => 'filter-form')) !!}

            @foreach($extraFilterFields as $title => $row) 
            <h6>{!! $title !!}</h6>

            <ul>
                @foreach($row['options'] as $key => $val) 
                @if(isset($inputFields['filter']['extra_field'][$title][$key]))  
                <li><input type="checkbox" id="filter[extra_field][{!! $title !!}][{!! $key !!}]" class="filter-checkbox" name="filter[extra_field][{!! $title !!}][{!! $key !!}]" value="{!! $key !!}" checked="checked" /><label for="filter[extra_field][{!! $title !!}][{!! $key !!}]">{!! $val !!}</label></li>
                @else
                <li><input type="checkbox" id="filter[extra_field][{!! $title !!}][{!! $key !!}]" class="filter-checkbox" name="filter[extra_field][{!! $title !!}][{!! $key !!}]" value="{!! $key !!}" /><label for="filter[extra_field][{!! $title !!}][{!! $key !!}]">{!! $val !!}</label></li>
                @endif  
                @endforeach
            </ul>

            @endforeach            
            </form>
            @endif

            @if($filterCombinations)

            {!! Form::open(array('route' => array('product.category.ajax', $category->slug), 'class' => 'filter-form')) !!}

            @foreach($filterCombinations as $title => $row) 
            <h6>{!! $title !!}</h6>
            <ul>
                @foreach($row['options'] as $key => $val) 
                @if(isset($inputFields['filter']['product_attribute'][$title][$key]))  
                <li><input type="checkbox" id="filter[product_attribute][{!! $title !!}][{!! $key !!}]" class="filter-checkbox" name="filter[product_attribute][{!! $title !!}][{!! $key !!}]" value="{!! $key !!}" checked="checked" /><label for="filter[product_attribute][{!! $title !!}][{!! $key !!}]">{!! $val !!}</label></li>
                @else
                <li><input type="checkbox" id="filter[product_attribute][{!! $title !!}][{!! $key !!}]" class="filter-checkbox" name="filter[product_attribute][{!! $title !!}][{!! $key !!}]" value="{!! $key !!}" /><label for="filter[product_attribute][{!! $title !!}][{!! $key !!}]">{!! $val !!}</label></li>
                @endif  
                @endforeach
            </ul>
            @endforeach

            </form>

            @endif 

        </div>
        @endif 
    </div>    

    <div class="small-15 medium-15  large-offset-1 large-11 columns">

        <div class="row">
            <div class="small-15 medium-8 large-8 columns">  
                <h1>{{ $category->title }}</h1>
                <div class="hide-for-medium">
                    <p>{!! $category->short_description !!}</p> 
                </div> 
                <div class="show-for-medium">
                    {!! $category->description !!}   
                </div> 
            </div>
            <div class="show-for-medium small-12 medium-6 medium-offset-1 large-offset-1 large-6 columns text-right">    

                @if($category->productCategoryImages->count())
                <img src="/files/product_category/200x200/{!! $category->productCategoryImages->first()->product_category_id !!}/{!! $category->productCategoryImages->first()->file !!}" class="img-responsive main-photo" alt="" />
                @endif   

            </div>  
        </div>    

        @if (isset($category->products))
        <div class="row blocks" data-equalizer data-equalize-on="medium">
            @if( $products )
            @foreach ($products as $product)
            @include('frontend.product_category._product-row')

            @endforeach
            @endif
        </div>
        @endif

    </div>

</div>