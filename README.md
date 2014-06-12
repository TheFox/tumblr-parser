# Tumblr Parser
A Tumblr Theme parser in PHP.

Tired of getting sick of Tumblrs online HTML editor for custom themes? With Tumblr Parser you can edit a theme in your favourite HTML editor and render the output in your browser on your own/local server. So you can create themes for Tumblr without editing the HTML in Tumblr's online HTML editor.

## Installation
The preferred method of installation is via [Packagist](https://packagist.org/packages/thefox/tumblr-parser) and [Composer](https://getcomposer.org/). Run the following command to install the package and add it as a requirement to composer.json:

`composer.phar require "thefox/tumblr-parser=0.1.*"`

## [Tumblr Custom Theme](http://www.tumblr.com/docs/en/custom_themes) Implementation
### [Basic Variables](http://www.tumblr.com/docs/en/custom_themes#basic_variables) [incomplete]
- `{Title}`
- `{Description}`
- `{CustomCSS}`
- `{block:PermalinkPage}`
- `{block:IndexPage}`
- `{block:PostTitle}`, `{PostTitle}`

### [Navigation](https://www.tumblr.com/docs/en/custom_themes#navigation) [incomplete]
- `{block:Pagination}`
- `{block:PreviousPage}`
- `{block:NextPage}`
- `{PreviousPage}`
- `{NextPage}`
- `{CurrentPage}`
- `{TotalPages}`
- `{block:AskEnabled}`
- `{AskLabel}`
- `{block:HasPages}`
- `{block:Pages}`
- `{URL}`
- `{Label}`

### [Posts](http://www.tumblr.com/docs/en/custom_themes#posts) [incomplete]
- `{block:Posts}`
- `{block:Text}`
- `{block:Link}`
- `{block:Photo}`
- `{block:Photoset}`
- `{Permalink}`
- `{PostID}`

### [Text Posts](http://www.tumblr.com/docs/en/custom_themes#text-posts) [complete]

### [Photo Posts](http://www.tumblr.com/docs/en/custom_themes#photo-posts) [incomplete]
- `{PhotoAlt}`
- `{block:Caption}`
- `{Caption}`
- `{block:LinkURL}`
- `{LinkURL}`
- `{LinkOpenTag}`
- `{LinkCloseTag}`
- `{PhotoURL-500}`

### [Photoset Posts](http://www.tumblr.com/docs/en/custom_themes#photoset-posts) [incomplete]
- `{block:Caption}`
- `{Caption}`
- `{block:Photos}`

### [Quote Posts](http://www.tumblr.com/docs/en/custom_themes#quote-posts) [complete]

### [Link Posts](http://www.tumblr.com/docs/en/custom_themes#link-posts) [incomplete]
- `{URL}`
- `{Name}`
- `{Target}`
- `{block:Description}`
- `{Description}`

### [Dates](https://www.tumblr.com/docs/en/custom_themes#dates) [incomplete]
- `{block:Date}`
- `{DayOfMonth}`
- `{DayOfMonth}`
- `{Month}`
- `{Year}`

### [Notes](https://www.tumblr.com/docs/en/custom_themes#notes) [incomplete]
- `{block:PostNotes}`
- `{PostNotes}`
- `{NoteCount}`
- `{NoteCountWithLabel}`

### [Tags](https://www.tumblr.com/docs/en/custom_themes#tags) [incomplete]
- `{block:HasTags}`
- `{block:Tags}`
- `{Tag}`
- `{TagURL}`

### [Like and Reblog buttons](https://www.tumblr.com/docs/en/custom_themes#like_and_reblog_buttons) [incomplete]
- `{LikeButton}`
- `{NoteCount}`

### [Theme Options](http://www.tumblr.com/docs/en/custom_themes#theme-options) [incomplete]
- Enabling Booleans [complete]
- Enabling Custom Text [complete]

## Contribute
You're welcome to contribute to this project. Fork this project at <https://github.com/TheFox/tumblr-parser>. You should read GitHub's [How to Fork a Repo](https://help.github.com/articles/fork-a-repo).

## License
See [LICENSE.md](LICENSE.md) file.
