<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * JobeetJobAffiliate filter form base class.
 *
 * @package    jobeet
 * @subpackage filter
 * @author     Your name here
 */
class BaseJobeetJobAffiliateFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
    ));

    $this->setValidators(array(
    ));

    $this->widgetSchema->setNameFormat('jobeet_job_affiliate_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'JobeetJobAffiliate';
  }

  public function getFields()
  {
    return array(
      'job_id'       => 'ForeignKey',
      'affiliate_id' => 'ForeignKey',
    );
  }
}
