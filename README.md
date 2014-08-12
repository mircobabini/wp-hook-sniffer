# WordPress Advanced Hook Sniffer

![WordPress Advanced Hook Sniffer plugin by Mirco Babini](http://sed-web.com/pi.php?n=hook-sniffer "WordPress Advanced Hook Sniffer plugin for WordPress by Mirco Babini")

**The WordPress Hook Sniffer plugin is a tool for plugin developers that helps determine the sequence in which action and filter functions are fired.**

## Description
The WordPress Hook Sniffer plugin is a tool for plugin developers that helps determine the sequence in which action and filter functions are fired. It allows you to peer into the inner workings of the WordPress Plugin API. You can configure what is outputted and to where the output is sent (screen or text file).

Since it's not supported anymore from the original author, it's now maintained by [Mirco Babini](http://www.mircobabini.com/).

## Output Options
You can choose to output any or all of the six different sets of hook data that WordPress Hook Sniffer collects. Each dataset provides a unique insight into the underlying working of WordPress' hooks. The currently available datasets are:

### Added Functions
A listing of, in the order in which they were encountered during code execution, all add_action calls and add_filter calls

### Removed Functions
A listing of, in the order in which they were encountered during code execution, all remove_action calls and remove_filter calls

### Action and Filter Function Array
Output the array that holds all of the added action and filter functions used by the do_action and apply_filters functions

### Action Event Firing Order
A sequential listing of all the do_action events that need to be processed

### Action Event Firing Sequence
A sequential listing of do_action events and their corresponding fired action function(s)

### Filter Event Firing Sequence
A sequential listing of apply_filters events with their corresponding fired filter  function(s)


## WARNING
This plugin is to be used only in a development sandbox and not in a production environment.

## Contribute
If you wanna contribute, pull requests on [github.com](https://github.com/mircobabini/wpml-shortcodes/pulls).

## Installation

Simply search for ‘WPML Shortcodes’ in the Plugins Admin page, then install and activate it. That's it!

## Credits

Developed by [Mirco Babini](http://www.mircobabini.com/donate) (Web Developer & Mobile App Developer), CEO @ [SED Web](http://www.sedweb.it)
Originally from [@jeffsayre](http://twitter.com/jeffsayre)

##### License: [GPLv3](http://www.gnu.org/licenses/gpl.html)
##### [WordPress Advanced Hook Sniffer on wordpress.org/plugins](http://wordpress.org/plugins/hook-sniffer/)
