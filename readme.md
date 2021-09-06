# Task Interface Management
## Features

* A "Task" custom post type with the fields you would expect: priority, due date, category, etc
* Support for Administrator, Editor, Author, and Contributor user roles only at this time.

## WordPress Requirements

1. Single site install support only at this time.

## Installation
1. Download the plugin via Github and delete all files and folders except for: /src/, LICENSE.txt, readme.md, task-interface-management.php, and package.json.
2. Compress the plugin to a ZIP file named "task-interface-management.zip".
3. Upload the plugin to your site via the admin dashboard plugin uploader.

## Developer Notes

This repository uses [PHP CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer/) with WordPress coding standards checks and a pre-commit hook. Pretty neat! I have made efforts to make this repository work between my Mac (terminal) and Windows (powershell) environments with the VSCode editor.

Line endings are enforced as WordPress-style CRLF "\r\n". This is what WordPress requires for its Subversion version control system, which is what developers must use to submit their WordPress plugins and themes to the official WordPress public extension library.

## Roadmap of future improvements
1. Settings page with user role management.
2. Multisite support.
3. Admin comment system.
