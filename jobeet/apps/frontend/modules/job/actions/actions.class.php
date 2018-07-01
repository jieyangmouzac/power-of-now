<?php

/**
 * job actions.
 *
 * @package    jobeet
 * @subpackage job
 * @author     Your name here
 */
class jobActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->jobeet_job_list = JobeetJobPeer::doSelect(new Criteria());
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->jobeet_job = JobeetJobPeer::retrieveByPk($request->getParameter('id'));
    $this->forward404Unless($this->jobeet_job);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new JobeetJobForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod('post'));

    $this->form = new JobeetJobForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($jobeet_job = JobeetJobPeer::retrieveByPk($request->getParameter('id')), sprintf('Object jobeet_job does not exist (%s).', $request->getParameter('id')));
    $this->form = new JobeetJobForm($jobeet_job);
  }

  public function get_count(){
      static $count = 0;
      return $count++;
  }

  public function bubble_sort($array){
      /*$count = count($array);
      if ($count <= 0) return false;
      for($i=0; $i<$count; $i++){
          for($j=$i; $j<$count; $j++){
              if ($array[$i] > $array[$j]){
                  $tmp = $array[$i];
                  $array[$i] = $array[$j];
                  $array[$j] = $tmp;
              }
          }
      }
      return $array;*/

      $cnt = count($array);
      if ($cnt < 1) return false;
      $i = 0;
      while ($i < $cnt) {
          $j = $i;
          while ($j < $cnt) {
              if ($array[$i] > $array[$j] )  {
                  $tmp = $array[$j];
                  $array[$j] = $array[$i] ;
                  $array[$i] = $tmp;
              }
              $j = $j + 1;
          }

          $i = $i + 1;
      }
      return $array;
  }

  public function quickSort($array){
      if (count($array) <= 1) return $array;
      $key = $array[0];
      $left_arr = array();
      $right_arr = array();
      for ($i=1; $i<count($array); $i++){
          if ($array[$i] <= $key)
              $left_arr[] = $array[$i];
          else
              $right_arr[] = $array[$i];
      }
      $left_arr = $this->quickSort($left_arr);
      $right_arr = $this->quickSort($right_arr);
      return array_merge($left_arr, array($key), $right_arr);
  }

  public function seq_sch($array, $n, $k){
      $array[$n] = $k;
      for($i=0; $i<$n; $i++){
          if($array[$i]==$k){
              break;
          }
      }
      if ($i<$n){
          return $i;
      }else{
          return -1;
      }
  }

    function bin_sch($array, $low, $high, $k){
        if ($low <= $high){

            $mid = intval(($low+$high)/2);
            if ($array[$mid] == $k){
                return $mid;
            }elseif ($k < $array[$mid]){
                return $this->bin_sch($array, $low, $mid-1, $k);
            }else{
                return $this->bin_sch($array, $mid+1, $high, $k);
            }
        }
        return -1;

    }

    function array_sort($arr, $keys, $order=0) {
        function arraySort($array, $keys, $sort = 'SORT_DESC') {
            $keysValue = [];
            foreach ($array as $k => $v) {
                $keysValue[$k] = $v[$keys];
            }
            array_multisort($keysValue, $sort, $array);
            return $array;
        }
    }

  public function executeUpdate(sfWebRequest $request)

  {
    $this->forward404Unless($request->isMethod('post') || $request->isMethod('put'), sprintf('update post (%s).', $request->isMethod('post') ));

    $this->forward404Unless($jobeet_job = JobeetJobPeer::retrieveByPk($request->getParameter('id')), sprintf('Object jobeet_job does not exist (%s).', $request->getParameter('id')));

    $this->form = new JobeetJobForm($jobeet_job);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($jobeet_job = JobeetJobPeer::retrieveByPk($request->getParameter('id')), sprintf('Object jobeet_job does not exist (%s).', $request->getParameter('id')));
    $jobeet_job->delete();

    $this->redirect('job/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $jobeet_job = $form->save();

      $this->redirect('job/edit?id='.$jobeet_job->getId());
    }
  }
}
