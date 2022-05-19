<?php

namespace SpeackWithUs\Modules\Enrollment\Interfaces;

interface IEnrollmetRepository
{
    public function applyToWork(int $projectId, int $userId);
    public function approvedToWork(int $projectId, int $userId);
    
    public function getAllEnrollments();
    public function getEnrollments(int $userid);
    public function getEnrollmentsByCategory(int $categoryId);
    
    public function findBySubscribeJob(int $projectId, int $userId);
}
