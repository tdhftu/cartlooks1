 @php
     //pickup order from  plugin
     $isactivatePickupPoint = isActivePlugin('pickuppoint-cartlooks');
     $order_pickup_point_active_link_file_links = [];
     $order_pickup_point_active_link_file = base_path() . '/plugins/pickuppoint-cartlooks/views/includes/submenu/order_active_link.json';
     if (file_exists($order_pickup_point_active_link_file)) {
         $order_pickup_point_active_link_file_links = json_decode(file_get_contents($order_pickup_point_active_link_file), true);
     }
     $isactivateMultivendor = isActivePlugin('multivendor-cartlooks');
     //Seller Products from  plugin
     $seller_products_active_link_file_links = [];
     $seller_products_active_link_file = base_path() . '/plugins/multivendor-cartlooks/views/includes/submenu/products_active_link.json';
     if (file_exists($seller_products_active_link_file)) {
         $seller_products_active_link_file_links = json_decode(file_get_contents($seller_products_active_link_file), true);
     }
     //Seller order from  plugin
     $order_seller_active_link_file_links = [];
     $order_seller_active_link_file = base_path() . '/plugins/multivendor-cartlooks/views/includes/submenu/order_active_link.json';
     if (file_exists($order_seller_active_link_file)) {
         $order_seller_active_link_file_links = json_decode(file_get_contents($order_seller_active_link_file), true);
     }
 @endphp
 <!--Products Module-->
 @if (auth()->user()->can('Manage Add New Product') ||
         auth()->user()->can('Manage Inhouse Products') ||
         auth()->user()->can('Manage Colors') ||
         auth()->user()->can('Manage Brands') ||
         auth()->user()->can('Manage Categories') ||
         auth()->user()->can('Manage Attributes') ||
         auth()->user()->can('Manage Units') ||
         auth()->user()->can('Manage Product Reviews') ||
         auth()->user()->can('Manage Product collections') ||
         auth()->user()->can('Manage Product Tags') ||
         auth()->user()->can('Manage Product Conditions'))
     <li
         class="{{ Request::routeIs($seller_products_active_link_file_links, ['plugin.cartlookscore.product.reviews.list','plugin.cartlookscore.product.collection.products','plugin.cartlookscore.product.collection.edit','plugin.cartlookscore.product.collection.add.new','plugin.cartlookscore.product.collection.list','plugin.cartlookscore.product.edit','plugin.cartlookscore.product.list','plugin.cartlookscore.product.add.new','plugin.cartlookscore.product.units.edit','plugin.cartlookscore.product.attributes.values.edit','plugin.cartlookscore.product.attributes.values','plugin.cartlookscore.product.attributes.edit','plugin.cartlookscore.product.attributes.add','plugin.cartlookscore.product.attributes.list','plugin.cartlookscore.product.tags.edit','plugin.cartlookscore.product.tags.add.new','plugin.cartlookscore.product.tags.list','plugin.cartlookscore.product.conditions.edit','plugin.cartlookscore.product.conditions.new','plugin.cartlookscore.product.conditions.list','plugin.cartlookscore.product.units.new','plugin.cartlookscore.product.units.list','plugin.cartlookscore.product.colors.edit','plugin.cartlookscore.product.colors.list','plugin.cartlookscore.product.colors.new','plugin.cartlookscore.product.brand.edit','plugin.cartlookscore.product.brand.new','plugin.cartlookscore.product.category.list','plugin.cartlookscore.product.category.new','plugin.cartlookscore.product.category.edit','plugin.cartlookscore.product.brand.list'])? 'active sub-menu-opened': '' }}">
         <a href="#">
             <i class="icofont-bucket1"></i>
             <span class="link-title"> {{ translate('Products') }}</span>
         </a>
         <ul class="nav sub-menu">
             @if (auth()->user()->can('Manage Add New Product'))
                 <li class="{{ Request::routeIs(['plugin.cartlookscore.product.add.new']) ? 'active ' : '' }}">
                     <a href="{{ route('plugin.cartlookscore.product.add.new') }}">{{ translate('Add New Product') }}</a>
                 </li>
             @endif
             @if (auth()->user()->can('Manage Inhouse Products'))
                 <li class="{{ Request::routeIs(['plugin.cartlookscore.product.list']) ? 'active ' : '' }}">
                     <a href="{{ route('plugin.cartlookscore.product.list') }}">
                         @if ($isactivateMultivendor)
                             {{ translate('Inhouse Products') }}
                         @else
                             {{ translate('All Products') }}
                         @endif
                     </a>
                 </li>
                 @if ($isactivateMultivendor)
                     @includeIf('plugin/multivendor-cartlooks::includes.submenu.products')
                 @endif
             @endif
             @if (auth()->user()->can('Manage Colors'))
                 <li
                     class="{{ Request::routeIs(['plugin.cartlookscore.product.colors.edit', 'plugin.cartlookscore.product.colors.list', 'plugin.cartlookscore.product.colors.new']) ? 'active ' : '' }}">
                     <a href="{{ route('plugin.cartlookscore.product.colors.list') }}">{{ translate('Colors') }}</a>
                 </li>
             @endif
             @if (auth()->user()->can('Manage Brands'))
                 <li
                     class="{{ Request::routeIs(['plugin.cartlookscore.product.brand.edit', 'plugin.cartlookscore.product.brand.list', 'plugin.cartlookscore.product.brand.new']) ? 'active ' : '' }}">
                     <a href="{{ route('plugin.cartlookscore.product.brand.list') }}">{{ translate('Brands') }}</a>
                 </li>
             @endif

             @if (auth()->user()->can('Manage Categories'))
                 <li
                     class="{{ Request::routeIs(['plugin.cartlookscore.product.category.list', 'plugin.cartlookscore.product.category.new', 'plugin.cartlookscore.product.category.edit']) ? 'active ' : '' }}">
                     <a
                         href="{{ route('plugin.cartlookscore.product.category.list') }}">{{ translate('Categories') }}</a>
                 </li>
             @endif

             @if (auth()->user()->can('Manage Attributes'))
                 <li
                     class="{{ Request::routeIs(['plugin.cartlookscore.product.attributes.values.edit', 'plugin.cartlookscore.product.attributes.values', 'plugin.cartlookscore.product.attributes.edit', 'plugin.cartlookscore.product.attributes.add', 'plugin.cartlookscore.product.attributes.list']) ? 'active ' : '' }}">
                     <a
                         href="{{ route('plugin.cartlookscore.product.attributes.list') }}">{{ translate('Attributes') }}</a>
                 </li>
             @endif

             @if (auth()->user()->can('Manage Units'))
                 <li
                     class="{{ Request::routeIs(['plugin.cartlookscore.product.units.edit', 'plugin.cartlookscore.product.units.new', 'plugin.cartlookscore.product.units.list']) ? 'active ' : '' }}">
                     <a href="{{ route('plugin.cartlookscore.product.units.list') }}">{{ translate('Units') }}</a>
                 </li>
             @endif

             @if (auth()->user()->can('Manage Product Reviews'))
                 <li class="{{ Request::routeIs(['plugin.cartlookscore.product.reviews.list']) ? 'active ' : '' }}">
                     <a
                         href="{{ route('plugin.cartlookscore.product.reviews.list') }}">{{ translate('Product Reviews') }}</a>
                 </li>
             @endif

             @if (auth()->user()->can('Manage Product collections'))
                 <li class="{{ Request::routeIs(['plugin.cartlookscore.product.collection.list']) ? 'active ' : '' }}">
                     <a
                         href="{{ route('plugin.cartlookscore.product.collection.list') }}">{{ translate('Product collections') }}</a>
                 </li>
             @endif

             @if (auth()->user()->can('Manage Product Tags'))
                 <li
                     class="{{ Request::routeIs(['plugin.cartlookscore.product.tags.edit', 'plugin.cartlookscore.product.tags.add.new', 'plugin.cartlookscore.product.tags.list']) ? 'active ' : '' }}">
                     <a
                         href="{{ route('plugin.cartlookscore.product.tags.list') }}">{{ translate('Product Tags') }}</a>
                 </li>
             @endif

             @if (auth()->user()->can('Manage Product conditions'))
                 <li
                     class="{{ Request::routeIs(['plugin.cartlookscore.product.conditions.edit', 'plugin.cartlookscore.product.conditions.new', 'plugin.cartlookscore.product.conditions.list']) ? 'active ' : '' }}">
                     <a
                         href="{{ route('plugin.cartlookscore.product.conditions.list') }}">{{ translate('Product conditions') }}</a>
                 </li>
             @endif
         </ul>
     </li>
 @endif

 <!--End Products Module-->
 <!--Orders Module-->
 @if (auth()->user()->can('Manage Inhouse Orders') ||
         auth()->user()->can('Manage Pickup Point Order'))
     <li
         class="{{ Request::routeIs($order_pickup_point_active_link_file_links, $order_seller_active_link_file_links, ['plugin.cartlookscore.orders.details', 'plugin.cartlookscore.orders.inhouse']) ? 'active sub-menu-opened' : '' }}">
         <a href="#">
             <i class="icofont-cart"></i>
             <span class="link-title">{{ translate('Orders') }}</span>
         </a>
         <ul class="nav sub-menu">
             @if (auth()->user()->can('Manage Inhouse Orders'))
                 <li class="{{ Request::routeIs(['plugin.cartlookscore.orders.inhouse']) ? 'active ' : '' }}">
                     <a
                         href="{{ route('plugin.cartlookscore.orders.inhouse') }}">{{ translate('Inhouse Orders') }}</a>
                 </li>
             @endif

             @if ($isactivateMultivendor)
                 @includeIf('plugin/multivendor-cartlooks::includes.submenu.order')
             @endif
             @if ($isactivatePickupPoint)
                 @includeIf('plugin/pickuppoint-cartlooks::includes.submenu.order')
             @endif

         </ul>
     </li>
 @endif

 <!--End Orders Module-->

 @if (auth()->user()->can('Manage Customers'))
     <!--Customer Module-->
     <li class="{{ Request::routeIs(['plugin.cartlookscore.customers.list']) ? 'active' : '' }}">
         <a href="{{ route('plugin.cartlookscore.customers.list') }}">
             <i class="icofont-users-alt-4"></i>
             <span class="link-title">{{ translate('Customers') }}</span>
         </a>

     </li>
     <!--End Customer module-->
 @endif

 <!--Shippings Module-->
 @php
     //carrier  plugin
     $isactivateCarrier = isActivePlugin('carrier-cartlooks');
     $shipping_carrier_active_link_file_links = [];
     $shipping_carrier_active_link_file = base_path() . '/plugins/carrier-cartlooks/views/includes/submenu/shipping_active_link.json';
     if (file_exists($shipping_carrier_active_link_file)) {
         $shipping_carrier_active_link_file_links = json_decode(file_get_contents($shipping_carrier_active_link_file), true);
     }
     //pickup  plugin
     $isactivatePickupPoint = isActivePlugin('pickuppoint-cartlooks');
     $shipping_pickup_point_active_link_file_links = [];
     $shipping_pickup_point_active_link_file = base_path() . '/plugins/pickuppoint-cartlooks/views/includes/submenu/shipping_active_link.json';
     if (file_exists($shipping_pickup_point_active_link_file)) {
         $shipping_pickup_point_active_link_file_links = json_decode(file_get_contents($shipping_pickup_point_active_link_file), true);
     }
     //delivery boy plugun
     $isactivateDeliveryBoy = isActivePlugin('deliveryboy');
     $shipping_delivery_boy_active_link_file_links = [];
     $shipping_delivery_boy_active_link_file = base_path() . '/plugins/deliveryboy/views/includes/submenu/shipping_active_link.json';
     if (file_exists($shipping_delivery_boy_active_link_file)) {
         $shipping_delivery_boy_active_link_file_links = json_decode(file_get_contents($shipping_delivery_boy_active_link_file), true);
     }
 @endphp

 @if (auth()->user()->can('Manage Shipping & Delivery') ||
         auth()->user()->can('Manage Pickup Points') ||
         auth()->user()->can('Manage Carriers') ||
         auth()->user()->can('Manage Locations'))

     <li
         class="{{ Request::routeIs($shipping_carrier_active_link_file_links, $shipping_delivery_boy_active_link_file_links, $shipping_pickup_point_active_link_file_links, ['plugin.cartlookscore.shipping.profile.manage', 'plugin.cartlookscore.shipping.profile.form', 'plugin.cartlookscore.shipping.configuration', 'plugin.cartlookscore.shipping.locations.cities.edit', 'plugin.cartlookscore.shipping.locations.cities.add.new', 'plugin.cartlookscore.shipping.locations.cities.list', 'plugin.cartlookscore.shipping.locations.states.edit', 'plugin.cartlookscore.shipping.locations.states.new.add', 'plugin.cartlookscore.shipping.locations.states.list', 'plugin.cartlookscore.shipping.locations.country.edit', 'plugin.cartlookscore.shipping.locations.country.new', 'plugin.cartlookscore.shipping.locations.country.list']) ? 'active sub-menu-opened' : '' }}">
         <a href="#">
             <i class="icofont-ship"></i>
             <span class="link-title">{{ translate('Shippings') }}</span>
         </a>
         <ul class="nav sub-menu">
             @if (auth()->user()->can('Manage Shipping & Delivery'))
                 <li class="{{ Request::routeIs(['plugin.cartlookscore.shipping.configuration']) ? 'active ' : '' }}">
                     <a
                         href="{{ route('plugin.cartlookscore.shipping.configuration') }}">{{ translate('Shipping & Delivery') }}</a>
                 </li>
             @endif


             @if ($isactivatePickupPoint)
                 @if (auth()->user()->can('Manage Pickup Points'))
                     @includeIf('plugin/pickuppoint-cartlooks::includes.submenu.shipping')
                 @endif
             @endif

             @if ($isactivateCarrier)
                 @if (auth()->user()->can('Manage Carriers'))
                     @includeIf('plugin/carrier-cartlooks::includes.submenu.shipping')
                 @endif
             @endif

             @if (auth()->user()->can('Manage Locations'))
                 <li
                     class="{{ Request::routeIs(['plugin.cartlookscore.shipping.locations.cities.edit', 'plugin.cartlookscore.shipping.locations.cities.add.new', 'plugin.cartlookscore.shipping.locations.cities.list', 'plugin.cartlookscore.shipping.locations.states.edit', 'plugin.cartlookscore.shipping.locations.states.new.add', 'plugin.cartlookscore.shipping.locations.states.list', 'plugin.cartlookscore.shipping.locations.country.edit', 'plugin.cartlookscore.shipping.locations.country.new', 'plugin.cartlookscore.shipping.locations.country.list']) ? 'sub-menu-opened' : '' }}">
                     <a href="{{ route('core.languages') }}">{{ translate('Locations') }}</a>
                     <ul class="nav sub-menu">
                         <li
                             class="{{ Request::routeIs(['plugin.cartlookscore.shipping.locations.country.edit', 'plugin.cartlookscore.shipping.locations.country.new', 'plugin.cartlookscore.shipping.locations.country.list']) ? 'active ' : '' }}">
                             <a
                                 href="{{ route('plugin.cartlookscore.shipping.locations.country.list') }}">{{ translate('Countries') }}</a>
                         </li>
                         <li
                             class="{{ Request::routeIs(['plugin.cartlookscore.shipping.locations.states.edit', 'plugin.cartlookscore.shipping.locations.states.new.add', 'plugin.cartlookscore.shipping.locations.states.list']) ? 'active ' : '' }}">
                             <a
                                 href="{{ route('plugin.cartlookscore.shipping.locations.states.list') }}">{{ translate('States') }}</a>
                         </li>
                         <li
                             class="{{ Request::routeIs(['plugin.cartlookscore.shipping.locations.cities.edit', 'plugin.cartlookscore.shipping.locations.cities.add.new', 'plugin.cartlookscore.shipping.locations.cities.list']) ? 'active ' : '' }}">
                             <a
                                 href="{{ route('plugin.cartlookscore.shipping.locations.cities.list') }}">{{ translate('Cities') }}</a>
                         </li>
                     </ul>
                 </li>
             @endif
         </ul>
     </li>
 @endif

 <!--End Shippings Module-->



 <!--Payments Module-->
 @if (auth()->user()->can('Manage Payment Methods') ||
         auth()->user()->can('Manage Transaction history'))
     <li
         class="{{ Request::routeIs(['plugin.cartlookscore.payments.methods', 'plugin.cartlookscore.payments.transactions.history']) ? 'active sub-menu-opened' : '' }}">
         <a href="#">
             <i class="icofont-money"></i>
             <span class="link-title">{{ translate('Payments') }}</span>
         </a>
         <ul class="nav sub-menu">
             @if (auth()->user()->can('Manage Payment Methods'))
                 <li class="{{ Request::routeIs(['plugin.cartlookscore.payments.methods']) ? 'active ' : '' }}">
                     <a
                         href="{{ route('plugin.cartlookscore.payments.methods') }}">{{ translate('Payment Methods') }}</a>
                 </li>
             @endif
             @if (auth()->user()->can('Manage Transaction history'))
                 <li
                     class="{{ Request::routeIs(['plugin.cartlookscore.payments.transactions.history']) ? 'active ' : '' }}">
                     <a
                         href="{{ route('plugin.cartlookscore.payments.transactions.history') }}">{{ translate('Transaction history') }}</a>
                 </li>
             @endif
         </ul>
     </li>
 @endif
 <!--End Payments Module-->


 <!--Marketings Module-->
 @php
     //flashdeal plugin
     $isactivateFlashdeal = isActivePlugin('flashdeal-cartlooks');
     $marketing_active_link_file_links = [];
     $marketing_active_link_file = base_path() . '/plugins/flashdeal-cartlooks/views/includes/submenu/marketing_active_link.json';
     if (file_exists($marketing_active_link_file)) {
         $marketing_active_link_file_links = json_decode(file_get_contents($marketing_active_link_file), true);
     }
     //coupon plugin
     $isactivateCoupon = isActivePlugin('coupon-cartlooks');
     $marketing_coupon_active_link_file_links = [];
     $marketing_coupon_active_link_file = base_path() . '/plugins/coupon-cartlooks/views/includes/submenu/marketing_active_link.json';
     if (file_exists($marketing_coupon_active_link_file)) {
         $marketing_coupon_active_link_file_links = json_decode(file_get_contents($marketing_coupon_active_link_file), true);
     }
 @endphp
 @if (auth()->user()->can('Manage Flash Deals') ||
         auth()->user()->can('Manage Coupons') ||
         auth()->user()->can('Manage Custom notification'))
     <li
         class="{{ Request::routeIs($marketing_coupon_active_link_file_links, $marketing_active_link_file_links, ['plugin.cartlookscore.marketing.custom.notification', 'plugin.cartlookscore.marketing.custom.notification.create.new']) ? 'active sub-menu-opened' : '' }}">
         <a href="#">
             <i class="icofont-megaphone"></i>
             <span class="link-title">{{ translate('Marketing') }}</span>
         </a>
         <ul class="nav sub-menu">
             @if ($isactivateFlashdeal)
                 @includeIf('plugin/flashdeal-cartlooks::includes.submenu.marketing')
             @endif
             @if ($isactivateCoupon)
                 @includeIf('plugin/coupon-cartlooks::includes.submenu.marketing')
             @endif
             @if (auth()->user()->can('Manage Custom notification'))
                 <li
                     class="{{ Request::routeIs(['plugin.cartlookscore.marketing.custom.notification', 'plugin.cartlookscore.marketing.custom.notification.create.new']) ? 'active ' : '' }}">
                     <a
                         href="{{ route('plugin.cartlookscore.marketing.custom.notification') }}">{{ translate('Custom Notification') }}</a>
                 </li>
             @endif
         </ul>
     </li>
 @endif
 <!--End Marketings Module-->
 <!--Report Module-->
 @if (auth()->user()->can('Manage Product Reports') ||
         auth()->user()->can('Manage Keyword Search Reports') ||
         auth()->user()->can('Manage Wishlist Reports'))
     <li
         class="{{ Request::routeIs(['plugin.cartlookscore.reports.search.keyword', 'plugin.cartlookscore.reports.products.wishlist', 'plugin.cartlookscore.reports.products']) ? 'active sub-menu-opened' : '' }}">
         <a href="#">
             <i class="icofont-list"></i>
             <span class="link-title">{{ translate('Reports') }}</span>
         </a>
         <ul class="nav sub-menu">
             @if (auth()->user()->can('Manage Product Reports'))
                 <li class="{{ Request::routeIs(['plugin.cartlookscore.reports.products']) ? 'active ' : '' }}">
                     <a
                         href="{{ route('plugin.cartlookscore.reports.products') }}">{{ translate('Product Reports') }}</a>
                 </li>
             @endif

             @if (auth()->user()->can('Manage Keyword Search Reports'))
                 <li class="{{ Request::routeIs(['plugin.cartlookscore.reports.search.keyword']) ? 'active ' : '' }}">
                     <a
                         href="{{ route('plugin.cartlookscore.reports.search.keyword') }}">{{ translate('Keyword Search Reports') }}</a>
                 </li>
             @endif

             @if (auth()->user()->can('Manage Wishlist Reports'))
                 <li
                     class="{{ Request::routeIs(['plugin.cartlookscore.reports.products.wishlist']) ? 'active ' : '' }}">
                     <a
                         href="{{ route('plugin.cartlookscore.reports.products.wishlist') }}">{{ translate('Wishlist Reports') }}</a>
                 </li>
             @endif
         </ul>
     </li>
 @endif
 <!--End Report Module-->

 <!--Ecommerce Settings Module-->
 @if (auth()->user()->can('Manage Taxes') ||
         auth()->user()->can('Manage Settings') ||
         auth()->user()->can('Manage Currencies') ||
         auth()->user()->can('Manage Product Share Options'))
     <li
         class="{{ Request::routeIs(['plugin.cartlookscore.ecommerce.edit.currency', 'plugin.cartlookscore.ecommerce.add.currency', 'plugin.cartlookscore.ecommerce.all.currencies', 'plugin.cartlookscore.ecommerce.configuration', 'plugin.cartlookscore.ecommerce.settings.taxes.manage.rates', 'plugin.cartlookscore.products.share.options', 'plugin.cartlookscore.ecommerce.settings.taxes.list']) ? 'active sub-menu-opened' : '' }}">
         <a href="#">
             <i class="icofont-interface"></i>
             <span class="link-title">{{ translate('Ecommerce Settings') }}</span>
         </a>
         <ul class="nav sub-menu">
             @if (auth()->user()->can('Manage Settings'))
                 <li class="{{ Request::routeIs(['plugin.cartlookscore.ecommerce.configuration']) ? 'active ' : '' }}">
                     <a
                         href="{{ route('plugin.cartlookscore.ecommerce.configuration') }}">{{ translate('Settings') }}</a>
                 </li>
             @endif
             @if (auth()->user()->can('Manage Currencies'))
                 <li
                     class="{{ Request::routeIs(['plugin.cartlookscore.ecommerce.all.currencies']) ? 'active ' : '' }}">
                     <a
                         href="{{ route('plugin.cartlookscore.ecommerce.all.currencies') }}">{{ translate('Currencies') }}</a>
                 </li>
             @endif

             @if (auth()->user()->can('Manage Product Share Options'))
                 <li class="{{ Request::routeIs(['plugin.cartlookscore.products.share.options']) ? 'active ' : '' }}">
                     <a
                         href="{{ route('plugin.cartlookscore.products.share.options') }}">{{ translate('Product Share Options') }}</a>
                 </li>
             @endif
             @if (auth()->user()->can('Manage Taxes'))
                 <li
                     class="{{ Request::routeIs(['plugin.cartlookscore.ecommerce.settings.taxes.manage.rates', 'plugin.cartlookscore.ecommerce.settings.taxes.list']) ? 'active ' : '' }}">
                     <a
                         href="{{ route('plugin.cartlookscore.ecommerce.settings.taxes.list') }}">{{ translate('Tax') }}</a>
                 </li>
             @endif
         </ul>
     </li>
 @endif
 <!--End Ecommerce Settings Module-->
