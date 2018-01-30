# krokedil-logger
## Installation
Add this plugin as a submodule in your main plugin folder. And include the file **krokedil-order-event-log.php**.

## Usage
### Log event
Use the function **krokedil_log_events**. 
```
Example: krokedil_log_events( $order_id, $title, $data );
```
$order_id = The WooCommerce order id. Can be sent as null if you want to log events before an order exists.
$title = The title that you wish to have for the event.
$data = An **array** of the data that you want to log.

### Set the version used for order

Use the function **krokedil_set_order_version**. 
```
Example: krokedil_set_order_version( $order_id, $version );
```
$order_id = The WooCommerce order id.
$version = The version that you want to log for the order.
Use this function at a point where an order exists, for example thank you page or process_order.

### Recognition
This plugin uses the renderjson JavaScript created by GitHub user [Caldwell](https://github.com/caldwell/). It can be found here: [RenderJSON](https://github.com/caldwell/renderjson).