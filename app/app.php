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

        return $app['twig']->render('store.html.twig');
    });

    $app->post("/view_stores", function() use ($app) {
        $selected_store = Store::find($_POST['stores_list']);

        return $app['twig']->render('store.html.twig');
    });


    return $app;
?>
