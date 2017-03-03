<?php
    date_default_timezone_set('America/Los_Angeles');
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Brand.php";
    require_once __DIR__."/../src/Store.php";

    $app = new Silex\Application();

    $server = 'mysql:host=localhost:3306;dbname=shoes';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__.'/../views'));

    $app['debug'] = true;

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->get("/", function() use ($app) {

        return $app['twig']->render('index.html.twig', array('stores' => Store::getAll(), 'brands' => Brand::getAll()));
    });

    $app->get("/stores", function() use ($app) {

        return $app['twig']->render('stores.html.twig', array('stores' => Store::getAll(), 'brands' => Brand::getAll()));
    });

    $app->post("/add_store", function() use ($app) {
        $new_store = new Store($_POST['name'], $_POST['address'], $_POST['phone_number']);
        $new_store->save();

        return $app['twig']->render('stores.html.twig', array('stores' => Store::getAll(), 'brands' => Brand::getAll()));
    });

    $app->get("/store/{id}", function($id) use ($app) {
        $selected_store = Store::find($id);

        return $app['twig']->render('store.html.twig', array('store' => $selected_store, 'brands' => Brand::getAll(), 'stores' => Store::getAll(), 'store_brands' => $selected_store->getBrands()));
    });

    $app->post("/view_stores", function() use ($app) {
        $selected_store = Store::find($_POST['stores_list']);

        return $app['twig']->render('store.html.twig', array('store' => $selected_store, 'brands' => Brand::getAll(), 'stores' => Store::getAll(), 'store_brands' => $selected_store->getBrands()));
    });

    $app->delete("/store/{id}", function($id) use ($app) {
        $store = Store::find($id);
        $store->delete();

        return $app['twig']->render('stores.html.twig', array('stores' => Store::getAll(), 'brands' => Brand::getAll()));
    });

    $app->post("/store/{id}/edit", function($id) use ($app) {
        $store = Store::find($id);

        return $app['twig']->render('store_edit.html.twig', array('stores' => Store::getAll(), 'brands' => Brand::getAll(), 'store' => $store));
    });

    $app->patch("/update_store/{id}", function($id) use ($app) {
        $selected_store = Store::find($id);
        $selected_store->update($_POST['name'], $_POST['address'], $_POST['phone_number']);

        return $app['twig']->render('store.html.twig', array('store' => $selected_store, 'brands' => Brand::getAll(), 'stores' => Store::getAll(), 'store_brands' => $selected_store->getBrands()));
    });

    $app->get("/brands", function() use ($app) {

        return $app['twig']->render('brands.html.twig', array('stores' => Store::getAll(), 'brands' => Brand::getAll()));
    });

    $app->post("/add_brand", function() use ($app) {
        $new_brand = new Brand($_POST['name']);
        $new_brand->save();

        return $app['twig']->render('brands.html.twig', array('stores' => Store::getAll(), 'brands' => Brand::getAll()));
    });

    $app->delete("/brand/{id}", function($id) use ($app) {
        $brand = Brand::find($id);
        $brand->delete();

        return $app['twig']->render('brands.html.twig', array('stores' => Store::getAll(), 'brands' => Brand::getAll()));
    });

    $app->post("/brand/{id}/edit", function($id) use ($app) {
        $brand = Brand::find($id);

        return $app['twig']->render('brand_edit.html.twig', array('stores' => Store::getAll(), 'brands' => Brand::getAll(), 'brand' => $brand));
    });

    $app->patch("/update_brand/{id}", function($id) use ($app) {
        $brand = Brand::find($id);
        $brand->update($_POST['name']);

        return $app['twig']->render('brands.html.twig', array('stores' => Store::getAll(), 'brands' => Brand::getAll()));
    });

    $app->get("/brand/{id}", function($id) use ($app) {
        $brand = Brand::find($id);

        return $app['twig']->render('brand.html.twig', array('stores' => Store::getAll(), 'brands' => Brand::getAll(), 'brand_stores' => $brand->getStores(), 'brand' => $brand));
    });

    $app->post("/view_brands", function() use ($app) {
        $brand = Brand::find($_POST['brands_list']);

        return $app['twig']->render('brand.html.twig', array('stores' => Store::getAll(), 'brands' => Brand::getAll(), 'brand_stores' => $brand->getStores(), 'brand' => $brand));
    });

    $app->post("/add_brand/{store_id}/{brand_id}", function($store_id, $brand_id) use ($app) {
        $store = Store::find($store_id);
        $store->addBrand(Brand::find($brand_id));

        return $app['twig']->render('store.html.twig', array('store' => $store, 'brands' => Brand::getAll(), 'stores' => Store::getAll(), 'store_brands' => $store->getBrands()));
    });

    $app->post("/remove_brand/{store_id}/{brand_id}", function($store_id, $brand_id) use ($app) {
        $store = Store::find($store_id);
        $store->removeBrand(Brand::find($brand_id));

        return $app['twig']->render('store.html.twig', array('store' => $store, 'brands' => Brand::getAll(), 'stores' => Store::getAll(), 'store_brands' => $store->getBrands()));
    });

    $app->post("/add_store/{brand_id}/{store_id}", function($brand_id, $store_id) use ($app) {
        $brand = Brand::find($brand_id);
        $brand->addStore(Store::find($store_id));

        return $app['twig']->render('brand.html.twig', array('stores' => Store::getAll(), 'brands' => Brand::getAll(), 'brand_stores' => $brand->getStores(), 'brand' => $brand));
    });

    $app->post("/remove_store/{brand_id}/{store_id}", function($brand_id, $store_id) use ($app) {
        $brand = Brand::find($brand_id);
        $brand->removeStore(Store::find($store_id));

        return $app['twig']->render('brand.html.twig', array('stores' => Store::getAll(), 'brands' => Brand::getAll(), 'brand_stores' => $brand->getStores(), 'brand' => $brand));
    });


    return $app;
?>
