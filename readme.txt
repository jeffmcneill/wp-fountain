=== WP Fountain ===

Contributors: <a href="http://jeffmcneill.com/">jeffmcneill</a>
Tags: screenwriting, scrippets, scrippet, screenplay, film scripts, movie scripts, fountain, markdown
Requires at least: 1.5
Tested up to: 4.3
Stable tag: 1.5.9

WP Fountain supports Scrippets, aka Screen Play Markdown (SPMD) for screenplay display of text.

== Description ==

The Fountain format is a text format originally named Scrippets and designed by John August to allow writers to input screenplay text in easy-to-write plain text and have it converted to properly styled HTML. This plugin will automatically convert plain text Fountain to HTML, and add John August's Scrippets CSS file (renamed Fountains.CSSinto your blog. For more information on WP Fountain please see <http://mcneill.io/wp-fountain>

This plugin modifies screenplay format text for inclusion in web pages. Based on the <a href="http://johnaugust.com/archives/2008/scrippets-are-go">scrippet concept and original code</a> by <a href="http://johnaugust.com">John August</a> and <a href="http://equinox-of-insanity.com">Nima Yousefi</a>.

* Now available on <a href="https://github.com/jeffmcneill/wp-fountain">Github</a>
* <a href="http://wordpress.org/plugins/wp-fountain.zip">WP Fountain on Wordpress.org</a>
* <a href="https://jeffmcneill/wp-fountain/">WP Fountain</a> is a Wordpress Plugin to support <a href="http://fountain.io">Fountain markup</a> (aka <a href="http://prolost.com/storage/downloads/spmd/SPMD_proposal.html">SPMD</a>) for screenplays.

To include a Scrippet of Fountain in your WordPress blog simply include text in the following format:

> [fountain]
> INT. HOUSE - DAY
>
> MARY yells across the hall to FRANK.
>
> MARY
> Anything you want to tell me?
>
> FRANK (O.S.)
> I swear, honey, I don't know how mayonnaise got in the piano.
>
> CUT TO:
>
> FRANK
>
> running out of the bathroom.
>
> FRANK
> (terrified)
> There are bees in the toilet!
> [/fountain]

This renders as seen in <a href="http://wordpress.org/plugins/wp-fountain/screenshots/">screenshots</a>

Note: Fountain text must be wrapped in **`[fountain][/fountain]`** blocks, and must have correct line spaces between screenplay elements.

You can make text bold or italic by in the following ways:

= Bold =

* Wrap the text in double asterisks `**bold**`.

= Italic =

* Wrap the text in single asterisks `*italic*`.

Please note: text styling does not work for transitions. Sorry.

== Installation ==

1. Download wp-fountain.zip.
2. Unzip the archive.
3. Upload the entire "wp-fountain" folder into your "wp-content/plugins" directory.
4. Activate the plugin through the Admin plugins panel.
5. Enjoy!

== Frequently Asked Questions ==

= MEEP! It's not formatting correctly. What do I do? =

First, please make sure you are inputting the text in the right format. (Line spacing is important!)

However, if you're doing it right and it's still not looking right, please go to http://wordpress.org/plugins/wp-fountain/ for troubleshooting help or to submit a bug report.

= The fountains are formatted correctly, but the style of the box doesn't fit in with my blog design. What can I do? =

The fountains settings panel in your WordPress administrator's page has several settings that you can change to better suit your blog's design.

However, if those options are insufficient, you can modify the fountains.css file in *wp-fountain* plugin folder. Be advised that updates to the WP Fountain plugin will overwrite your changes, so you should back them up and remember to add them back in whenever the plugin gets updated.

== Screenshots ==

1. Display of WP Fountain marked up screenplay

== Changelog ==

=  1.5.7 =

* Various intervening changes to the text file, instructions, FAQ, and the like.

=  1.5.1 =

* Fork of WP Scrippets *

= 1.5 =

- Fixed screenshot.

= 1.4 =

* Various bug fixes.

= 1.35 =

* Fixed bug resulting from having a character name end in *INT* (ie, VINCINT, QUINT).

= 1.3 =

* Compatibility fix for WordPress 2.8+

= 1.2 =

* Fixed *FOREST* bug, added version number to scrippetize.php

= 1.1 =

* Added support for bold, italic, and underlined text.

= 1.0.2 =

* Fixed bug in wp-scrippets.php that prevented CSS to be added properly for blogs with different WordPress and Blog addresses.

= 1.0.1 =

* Fixed scrippetize to work with bbPress.

= 1.0 =

* Release!
