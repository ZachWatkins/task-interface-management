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

## Notices

* When you deactivate the plugin, the posts and taxonomy terms will not be deleted from the website. Nor will they be deleted if a user is deleted. This is to protect you in situations where you are asked to disable all plugins during the course of troubleshooting an issue with your website. At some point I will implement features that give control over this into a Settings page.

## Roadmap of future improvements
1. Admin comment system.
2. Settings page with user role management.
3. Multisite support.

## Developer Notes
Please refer to the [WordPress Coding Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/) when you have questions about how to format your code.

### Features
This repository uses [PHP CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer/) with WordPress coding standards checks and a pre-commit hook. Pretty neat! I have made efforts to make this repository work between my Mac (terminal) and Windows (powershell) environments with the VSCode editor.
### Conventions
Line endings are enforced as WordPress-style CRLF "\r\n". This is what WordPress requires for its Subversion version control system, which is what developers must use to submit their WordPress plugins and themes to the official WordPress public extension library.
### Lessons Learned
To add an executable file to git version control, do this: `git add --chmod=+x hooks/pre-commit && git commit -m "Add pre-commit executable hook"`

### Developer Potential Installation Issues
#### Local by Flywheel
I had to disable the Windows IIS service which was running on IP 0.0.0.0:80 and interfered with Local's Router functionality.
