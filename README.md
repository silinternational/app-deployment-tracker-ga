# Application Deployment Tracker using Google Analytics

This script uses Google Analytics to track an event whenever a deployment occurs. Calls to this script should be added 
to your deployment pipeline to be run after a successful deployment.

Since it is using Google Analytics there are some parameters where the names may not be intuitive to this usage. All 
parameters used are documented here.

## GA Parameters

| GA Parameter | Env Variable Name | Required |Default Value | Description |
|--------------|-------------------|----------|--------------|-------------|
| Tracking ID  | TRACKING_ID       | true     | none         | The GA property tracking ID, UA-something |
| User ID      | USER_ID           | false     | none         | Project or repo name, ex: silinternational/app-deployment-tracker-ga |
|              | USER_ID_VALUE_ENV_VAR | false | CI_REPO_NAME | If you want to get data source from another env var,  specify the env var name here. For example `CI_NAME` |
| Data Source  | DATA_SOURCE       | false    | script       | Name for source of where event came from, ex: script, codeship, etc. |
|              | DATA_SOURCE_VALUE_ENV_VAR | false | CI_NAME | If you want to get data source from another env var,  specify the env var name here. For example `CI_NAME` |
| Event Category | EVENT_CATEGORY  | false    | app-deployment | Category for events |
| Event Action   | EVENT_ACTION    | false    | master       | Action for event, default is "master" for master branch deployments |
|                | EVENT_ACTION_VALUE_ENV_VAR  | false | CI_BRANCH | If you want to pull the event action from another env var, specify the env var name here. For example `CI_BRANCH` |
| Event Label    | EVENT_LABEL     | false    | USER_ID      | Friendly name for project that was deployed, will use the same value as USER_ID if not provided |
| Document Title | DOCUMENT_TITLE  | false    | USER_ID      | Friendly name for project that was deployed, will use the same value as USER_ID if not provided |

It may be confusing at first, but we use the env vars above suffixed with `_VALUE_ENV_VAR` to allow us to load values 
dynamically from the CI environment. If you want to specify your own values you should set the `_VALUE_ENV_VAR` env 
var to the name of another env var that contains the value you provide.

For example, if you want `Data Source` to be "my own source name", you would set the following environment variables:

 - `DATA_SOURCE_VALUE_ENV_VAR=DATA_SOURCE`
 - `DATA_SOURCE=my own source name`
 
## Reference

 - PHP library used to send measurement events to Google: [theiconic/php-ga-measurement-protocol](https://github.com/theiconic/php-ga-measurement-protocol)
 - List of properties that can be sent with measurements: https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters
 
# License - MIT
MIT License

Copyright (c) 2017 SIL International

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.