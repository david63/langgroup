# Language groups extension for phpBB

An extension to automatically move a user to a group based on their language choice.

[![Build Status](https://github.com/david63/langgroup/workflows/Tests/badge.svg)](https://github.com/phpbb-extensions/david63/langgroup)
[![License](https://poser.pugx.org/david63/langgroup/license)](https://packagist.org/packages/david63/langgroup)
[![Latest Stable Version](https://poser.pugx.org/david63/langgroup/v/stable)](https://packagist.org/packages/david63/langgroup)
[![Latest Unstable Version](https://poser.pugx.org/david63/langgroup/v/unstable)](https://packagist.org/packages/david63/langgroup)
[![Total Downloads](https://poser.pugx.org/david63/langgroup/downloads)](https://packagist.org/packages/david63/langgroup)
[![codecov](https://codecov.io/gh/david63/langgroup/branch/master/graph/badge.svg?token=D2500PgRex)](https://codecov.io/gh/david63/langgroup)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/59902be2665c476dbd7951858c9ff769)](https://www.codacy.com/manual/david63/langgroup?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=david63/langgroup&amp;utm_campaign=Badge_Grade)

## Minimum Requirements
  * phpBB 3.3.0
  * PHP 7.1.3

## Install
 1. [Download the latest release](https://github.com/david63/langgroup/archive/3.3.zip) and unzip it.
 2. Unzip the downloaded release and copy it to the `ext` directory of your phpBB board.
 3. Navigate in the ACP to `Customise -> Manage extensions`.
 4. Look for `Language groups` under the Disabled Extensions list and click its `Enable` link.

## Usage
 1. To use this extension you will need to set up a User Group for each language that you want to use. The name of the User Group must be the same as the ISO language code for the language that you are using. You will then need to set the permissions for each User Group.

## Uninstall
 1. Navigate in the ACP to `Customise -> Manage extensions`.
 2. Click the `Disable` link for `Language groups`.
 3. To permanently uninstall, click `Delete Data`, then delete the langgroup folder from `phpBB/ext/david63/`.

## License
[GNU General Public License v2](http://opensource.org/licenses/GPL-2.0)

© 2020 - David Wood