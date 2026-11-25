<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CompanyController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $filterStatus = $request->query('status', 'all');

        $query = Company::with([
            'internships.group',
            'internships.student.user',
            'validatedExperiences.student.user',
        ]);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'ilike', "%{$search}%")
                    ->orWhere('city', 'ilike', "%{$search}%")
                    ->orWhere('address', 'ilike', "%{$search}%");
            });
        }

        $companies = $query->orderBy('name')->get();

        // Apply status filter if requested
        if ($filterStatus === 'available') {
            $companies = $companies->filter(fn (Company $c) => ! $c->quota_info['is_full']);
        } elseif ($filterStatus === 'full') {
            $companies = $companies->filter(fn (Company $c) => $c->quota_info['is_full']);
        }

        return view('student.companies.index', [
            'companies' => $companies,
            'search' => $search,
            'filterStatus' => $filterStatus,
        ]);
    }

    public function show(Company $company): View
    {
        $company->load([
            'internships.group.members.student.user',
            'internships.student.user',
            'validatedExperiences.student.user',
        ]);

        return view('student.companies.show', [
            'company' => $company,
            'quota' => $company->quota_info,
            'experiences' => $company->validatedExperiences,
        ]);
    }
}
