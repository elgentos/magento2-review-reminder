# Review Reminder Module for Magento 2

The Review Reminder Module for Magento 2 is a customizable tool that enables online shop owners to automate the process of sending review reminders to customers after the shipping method has been created + configurable days. This module provides a convenient way to request feedback and reviews from customers, helping to improve the reputation and credibility of your online store.

## Features

1. **Configuration Options**: The module allows you to configure the review link and the complaint link according to your specific requirements. You can set the URLs for these links to direct customers to the appropriate pages where they can leave reviews or submit complaints.

2. **Email Customization**: You have the flexibility to configure different email addresses for each shop. This feature enables you to send review reminder emails from specific addresses associated with each shop, providing a more personalized and professional touch.

3. **Delay Settings**: The module allows you to set a specific number of days to add to the shipping record creation date before sending the review reminder email. This gives customers enough time to receive and experience the product before being asked to provide a review.

## Installation

To install the Review Reminder Module for Magento 2, follow these steps:

1. **Manual Installation**:
    - Download the module package.
    - Extract the contents into the `app/code` directory of your Magento installation.
    - Enable the module by running the following commands from your Magento root directory:

      ```
      php bin/magento setup:upgrade
      php bin/magento setup:static-content:deploy -f
      php bin/magento cache:flush
      ```

    - After successful installation, the module will be ready to use.

2. **Composer Installation**:
    - Run the following commands from your Magento root directory:

      ```
      composer require elgentos/magento2-review-reminder
      php bin/magento setup:upgrade
      php bin/magento setup:static-content:deploy -f
      php bin/magento cache:flush
      ```

    - After successful installation, the module will be ready to use.

## Usage

After installing the module, it will automatically track the creation dates of shipping records. Once the specified number of days has passed since the shipping record was created, the module will send a review reminder email to the customer. The email will contain the configured links for leaving a review or submitting a complaint.

To configure the module, navigate to the admin panel of your Magento 2 store and follow these steps:

1. Go to **Stores** > **Configuration** > **Extensions** > **Elgentos** > **Review Reminder**.
2. Customize the review link and complaint link URLs to match your store's review and complaint pages.
3. Configure the email address to be used for each shop.
4. Adjust the number of additional days to add to the shipping record creation date before sending the review reminder email.

## Contributing

We welcome contributions to enhance the functionality of the Review Reminder Module. If you would like to contribute, please create a pull request.
