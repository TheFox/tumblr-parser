# Tumblr Parser

A Tumblr Theme parser in PHP.

Tired of getting sick of Tumblr's online HTML editor for custom themes? With Tumblr Parser you can edit a theme in your favourite HTML editor and render the output in your browser on your own/local server. So you can create themes for Tumblr without editing the HTML in Tumblr's online HTML editor.

## Project Outlines

The project outlines as described in my blog post about [Open Source Software Collaboration](https://blog.fox21.at/2019/02/21/open-source-software-collaboration.html).

- The main purpose of this software is to simulate the Tumblr online editor to provide a developer friendly environment.
- The features should not go beyond the features and functions Tumblr is providing. So the feature-set is kind of restricted what could be possible in the future. But still, feel free to request features.

## Installation

The preferred method of installation is via [Packagist](https://packagist.org/packages/thefox/tumblr-parser) and [Composer](https://getcomposer.org/). Run the following command to install the package and add it as a requirement to `composer.json`:

```bash
composer require thefox/tumblr-parser
```

## Get started

To get started first look into the [example.php](example/example.php) in the `example` directory. There are several ways to use this tool. You can generate a whole weblog or just a single post. You can do this in your browser or in background in your shell.

## Example

See example in [example directory](example).

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

### [Chat Posts](http://www.tumblr.com/docs/en/custom_themes#chat-posts) [complete]

### [Answer Posts](http://www.tumblr.com/docs/en/custom_themes#answer-posts) [incomplete]

- `{Question}`
- `{Answer}`
- `{Asker}`

### [Dates](https://www.tumblr.com/docs/en/custom_themes#dates) [incomplete]

- `{block:Date}`
- `{DayOfMonth}`
- `{DayOfMonthWithZero}`
- `{DayOfWeek}`
- `{ShortDayOfWeek}`
- `{DayOfWeekNumber}`
- `{DayOfMonthSuffix}`
- `{DayOfYear}`
- `{WeekOfYear}`
- `{Month}`
- `{ShortMonth}`
- `{MonthNumber}`
- `{MonthNumberWithZero}`
- `{Year}`
- `{ShortYear}`
- `{AmPm}`
- `{CapitalAmPm}`
- `{12Hour}`
- `{24Hour}`
- `{12HourWithZero}`
- `{24HourWithZero}`
- `{Minutes}`
- `{Seconds}`
- `{Timestamp}`

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

## Links

- [Packagist Package](https://packagist.org/packages/thefox/tumblr-parser)
