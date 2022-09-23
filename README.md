# Terminus Carbon Plugin

[![Terminus v2.x - v3.x Compatible](https://img.shields.io/badge/terminus-2.x%20--%203.x-green.svg)](https://github.com/pantheon-systems/terminus-carbon-plugin/tree/main)

A Terminus plugin for fetching carbon impact and other sustainability data.

## Configuration

These commands require no configuration

## Usage
* `terminus carbon:info`: Displays carbon information about a site. 
* `terminus carbon:org`: Displays the list of sites associated with an organization with carbon data.
* `terminus carbon:regions`: Print region info about the Pantheon regions in Google Cloud.

## Installation

To install this plugin using Terminus 3:
```
terminus self:plugin:install terminus-carbon-plugin
```

On older versions of Terminus:
```
mkdir -p ~/.terminus/plugins
curl https://github.com/pantheon-systems/terminus-carbon-plugin/archive/2.x.tar.gz -L | tar -C ~/.terminus/plugins -xvz
```
