# Task Interface Management
You may repurpose code from this repository for your own WordPress development since it uses a GPL-2.0+ license.

## WordPress Requirements

1. Advanced Custom Fields plugin

## Installation

1. [Download the latest release](https://github.com/zachwatkins/task-interface-management/releases/latest)
2. Upload the plugin to your site

## Features

* A "Task" custom post type with the fields you would expect: priority, due date, category, etc
* Commenting on tasks for collaboration
* Settings page

## Developer Notes

This repository uses [PHP CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer/) with WordPress coding standards checks and a pre-commit hook. Pretty neat! I have made efforts to make this repository work between my Mac (terminal) and Windows (powershell) environments with the VSCode editor.

Line endings are enforced as WordPress-style CRLF "\r\n". This is what WordPress requires for its Subversion version control system, which is what developers must use to submit their WordPress plugins and themes to the official WordPress public extension library.
