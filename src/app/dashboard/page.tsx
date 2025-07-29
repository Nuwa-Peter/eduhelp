'use client'

import { useState, useEffect, Suspense } from 'react'
import { useSearchParams } from 'next/navigation'
import { Button } from "@/components/ui/button"
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card"
import { Badge } from "@/components/ui/badge"
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/components/ui/tabs"
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar"
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table"
import {
  GraduationCap,
  Users,
  BookOpen,
  Calendar,
  BarChart3,
  Bell,
  Settings,
  LogOut,
  TrendingUp,
  Clock,
  Award,
  MessageSquare,
  FileText,
  DollarSign,
  UserCheck,
  BookMarked,
  Target,
  Star
} from "lucide-react"
import Link from "next/link"

// Mock data for demonstration
const mockData = {
  student: {
    name: "Sarah Johnson",
    id: "STU001",
    class: "Grade 11-A",
    gpa: 3.8,
    attendance: 95,
    grades: [
      { subject: "Mathematics", grade: "A", score: 92 },
      { subject: "Physics", grade: "A-", score: 88 },
      { subject: "Chemistry", grade: "B+", score: 85 },
      { subject: "English", grade: "A", score: 94 },
      { subject: "History", grade: "B", score: 82 }
    ],
    assignments: [
      { title: "Math Quiz 3", dueDate: "2024-01-15", status: "pending" },
      { title: "Physics Lab Report", dueDate: "2024-01-18", status: "submitted" },
      { title: "History Essay", dueDate: "2024-01-20", status: "pending" }
    ]
  },
  teacher: {
    name: "Dr. Michael Chen",
    id: "TEA001",
    subject: "Mathematics",
    classes: ["Grade 10-A", "Grade 11-B", "Grade 12-A"],
    students: 85,
    todayClasses: [
      { time: "09:00 AM", class: "Grade 10-A", subject: "Algebra" },
      { time: "11:00 AM", class: "Grade 11-B", subject: "Calculus" },
      { time: "02:00 PM", class: "Grade 12-A", subject: "Statistics" }
    ],
    recentGrades: [
      { student: "Emma Wilson", assignment: "Math Quiz", grade: "A", date: "2024-01-10" },
      { student: "John Smith", assignment: "Homework 5", grade: "B+", date: "2024-01-09" },
      { student: "Lisa Brown", assignment: "Math Quiz", grade: "A-", date: "2024-01-10" }
    ]
  },
  admin: {
    name: "Principal Roberts",
    totalStudents: 1247,
    totalTeachers: 68,
    totalClasses: 42,
    revenue: 125000,
    recentActivities: [
      { type: "enrollment", description: "New student enrolled: Alex Thompson", time: "2 hours ago" },
      { type: "grade", description: "Grade 12 exam results published", time: "4 hours ago" },
      { type: "payment", description: "Fee payment received: $2,500", time: "6 hours ago" }
    ]
  }
}

function DashboardContent() {
  const searchParams = useSearchParams()
  const [currentRole, setCurrentRole] = useState<'student' | 'teacher' | 'admin'>('student')

  useEffect(() => {
    const role = searchParams.get('role') as 'student' | 'teacher' | 'admin'
    if (role && ['student', 'teacher', 'admin'].includes(role)) {
      setCurrentRole(role)
    }
  }, [searchParams])

  const renderRoleSelector = () => (
    <div className="flex gap-2 mb-6">
      <Button
        variant={currentRole === 'student' ? 'default' : 'outline'}
        onClick={() => setCurrentRole('student')}
        size="sm"
      >
        Student View
      </Button>
      <Button
        variant={currentRole === 'teacher' ? 'default' : 'outline'}
        onClick={() => setCurrentRole('teacher')}
        size="sm"
      >
        Teacher View
      </Button>
      <Button
        variant={currentRole === 'admin' ? 'default' : 'outline'}
        onClick={() => setCurrentRole('admin')}
        size="sm"
      >
        Admin View
      </Button>
    </div>
  )

  const renderStudentDashboard = () => (
    <div className="space-y-6">
      {/* Student Header */}
      <div className="flex items-center space-x-4">
        <Avatar className="h-20 w-20">
          <AvatarImage src="/api/placeholder/80/80" />
          <AvatarFallback>SJ</AvatarFallback>
        </Avatar>
        <div>
          <h1 className="text-3xl font-bold">Welcome back, {mockData.student.name}!</h1>
          <p className="text-gray-600">{mockData.student.class} • Student ID: {mockData.student.id}</p>
          <div className="flex gap-4 mt-2">
            <Badge variant="secondary">GPA: {mockData.student.gpa}</Badge>
            <Badge variant="outline">Attendance: {mockData.student.attendance}%</Badge>
          </div>
        </div>
      </div>

      {/* Quick Stats */}
      <div className="grid grid-cols-1 md:grid-cols-4 gap-6">
        <Card>
          <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
            <CardTitle className="text-sm font-medium">Current GPA</CardTitle>
            <TrendingUp className="h-4 w-4 text-muted-foreground" />
          </CardHeader>
          <CardContent>
            <div className="text-2xl font-bold">{mockData.student.gpa}</div>
            <p className="text-xs text-muted-foreground">+0.2 from last semester</p>
          </CardContent>
        </Card>
        <Card>
          <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
            <CardTitle className="text-sm font-medium">Attendance</CardTitle>
            <UserCheck className="h-4 w-4 text-muted-foreground" />
          </CardHeader>
          <CardContent>
            <div className="text-2xl font-bold">{mockData.student.attendance}%</div>
            <p className="text-xs text-muted-foreground">Excellent attendance</p>
          </CardContent>
        </Card>
        <Card>
          <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
            <CardTitle className="text-sm font-medium">Pending Tasks</CardTitle>
            <FileText className="h-4 w-4 text-muted-foreground" />
          </CardHeader>
          <CardContent>
            <div className="text-2xl font-bold">3</div>
            <p className="text-xs text-muted-foreground">2 assignments, 1 quiz</p>
          </CardContent>
        </Card>
        <Card>
          <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
            <CardTitle className="text-sm font-medium">Class Rank</CardTitle>
            <Award className="h-4 w-4 text-muted-foreground" />
          </CardHeader>
          <CardContent>
            <div className="text-2xl font-bold">5th</div>
            <p className="text-xs text-muted-foreground">Out of 32 students</p>
          </CardContent>
        </Card>
      </div>

      <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {/* Current Grades */}
        <Card>
          <CardHeader>
            <CardTitle>Current Grades</CardTitle>
            <CardDescription>Your performance across all subjects</CardDescription>
          </CardHeader>
          <CardContent>
            <div className="space-y-4">
              {mockData.student.grades.map((grade, index) => (
                <div key={index} className="flex items-center justify-between">
                  <div>
                    <div className="font-medium">{grade.subject}</div>
                    <div className="text-sm text-gray-500">Score: {grade.score}%</div>
                  </div>
                  <Badge variant={grade.grade.startsWith('A') ? 'default' : grade.grade.startsWith('B') ? 'secondary' : 'outline'}>
                    {grade.grade}
                  </Badge>
                </div>
              ))}
            </div>
          </CardContent>
        </Card>

        {/* Upcoming Assignments */}
        <Card>
          <CardHeader>
            <CardTitle>Upcoming Assignments</CardTitle>
            <CardDescription>Stay on top of your deadlines</CardDescription>
          </CardHeader>
          <CardContent>
            <div className="space-y-4">
              {mockData.student.assignments.map((assignment, index) => (
                <div key={index} className="flex items-center justify-between">
                  <div>
                    <div className="font-medium">{assignment.title}</div>
                    <div className="text-sm text-gray-500">Due: {assignment.dueDate}</div>
                  </div>
                  <Badge variant={assignment.status === 'pending' ? 'destructive' : 'default'}>
                    {assignment.status}
                  </Badge>
                </div>
              ))}
            </div>
          </CardContent>
        </Card>
      </div>
    </div>
  )

  const renderTeacherDashboard = () => (
    <div className="space-y-6">
      {/* Teacher Header */}
      <div className="flex items-center space-x-4">
        <Avatar className="h-20 w-20">
          <AvatarImage src="/api/placeholder/80/80" />
          <AvatarFallback>MC</AvatarFallback>
        </Avatar>
        <div>
          <h1 className="text-3xl font-bold">Welcome, {mockData.teacher.name}!</h1>
          <p className="text-gray-600">{mockData.teacher.subject} Teacher • ID: {mockData.teacher.id}</p>
          <div className="flex gap-4 mt-2">
            <Badge variant="secondary">{mockData.teacher.students} Students</Badge>
            <Badge variant="outline">{mockData.teacher.classes.length} Classes</Badge>
          </div>
        </div>
      </div>

      {/* Quick Stats */}
      <div className="grid grid-cols-1 md:grid-cols-4 gap-6">
        <Card>
          <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
            <CardTitle className="text-sm font-medium">Total Students</CardTitle>
            <Users className="h-4 w-4 text-muted-foreground" />
          </CardHeader>
          <CardContent>
            <div className="text-2xl font-bold">{mockData.teacher.students}</div>
            <p className="text-xs text-muted-foreground">Across all classes</p>
          </CardContent>
        </Card>
        <Card>
          <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
            <CardTitle className="text-sm font-medium">Classes Today</CardTitle>
            <Calendar className="h-4 w-4 text-muted-foreground" />
          </CardHeader>
          <CardContent>
            <div className="text-2xl font-bold">{mockData.teacher.todayClasses.length}</div>
            <p className="text-xs text-muted-foreground">Scheduled for today</p>
          </CardContent>
        </Card>
        <Card>
          <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
            <CardTitle className="text-sm font-medium">Pending Grades</CardTitle>
            <BookMarked className="h-4 w-4 text-muted-foreground" />
          </CardHeader>
          <CardContent>
            <div className="text-2xl font-bold">12</div>
            <p className="text-xs text-muted-foreground">Assignments to grade</p>
          </CardContent>
        </Card>
        <Card>
          <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
            <CardTitle className="text-sm font-medium">Class Average</CardTitle>
            <Target className="h-4 w-4 text-muted-foreground" />
          </CardHeader>
          <CardContent>
            <div className="text-2xl font-bold">87%</div>
            <p className="text-xs text-muted-foreground">Overall performance</p>
          </CardContent>
        </Card>
      </div>

      <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {/* Today's Schedule */}
        <Card>
          <CardHeader>
            <CardTitle>Today's Schedule</CardTitle>
            <CardDescription>Your classes for today</CardDescription>
          </CardHeader>
          <CardContent>
            <div className="space-y-4">
              {mockData.teacher.todayClasses.map((classItem, index) => (
                <div key={index} className="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                  <div>
                    <div className="font-medium">{classItem.class}</div>
                    <div className="text-sm text-gray-500">{classItem.subject}</div>
                  </div>
                  <Badge variant="outline">{classItem.time}</Badge>
                </div>
              ))}
            </div>
          </CardContent>
        </Card>

        {/* Recent Grades */}
        <Card>
          <CardHeader>
            <CardTitle>Recent Grades</CardTitle>
            <CardDescription>Latest student submissions</CardDescription>
          </CardHeader>
          <CardContent>
            <div className="space-y-4">
              {mockData.teacher.recentGrades.map((grade, index) => (
                <div key={index} className="flex items-center justify-between">
                  <div>
                    <div className="font-medium">{grade.student}</div>
                    <div className="text-sm text-gray-500">{grade.assignment} • {grade.date}</div>
                  </div>
                  <Badge variant={grade.grade.startsWith('A') ? 'default' : 'secondary'}>
                    {grade.grade}
                  </Badge>
                </div>
              ))}
            </div>
          </CardContent>
        </Card>
      </div>
    </div>
  )

  const renderAdminDashboard = () => (
    <div className="space-y-6">
      {/* Admin Header */}
      <div className="flex items-center space-x-4">
        <Avatar className="h-20 w-20">
          <AvatarImage src="/api/placeholder/80/80" />
          <AvatarFallback>PR</AvatarFallback>
        </Avatar>
        <div>
          <h1 className="text-3xl font-bold">Welcome, {mockData.admin.name}!</h1>
          <p className="text-gray-600">School Administrator</p>
          <Badge variant="secondary" className="mt-2">Full Access</Badge>
        </div>
      </div>

      {/* Admin Stats */}
      <div className="grid grid-cols-1 md:grid-cols-4 gap-6">
        <Card>
          <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
            <CardTitle className="text-sm font-medium">Total Students</CardTitle>
            <Users className="h-4 w-4 text-muted-foreground" />
          </CardHeader>
          <CardContent>
            <div className="text-2xl font-bold">{mockData.admin.totalStudents.toLocaleString()}</div>
            <p className="text-xs text-muted-foreground">+12% from last year</p>
          </CardContent>
        </Card>
        <Card>
          <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
            <CardTitle className="text-sm font-medium">Teaching Staff</CardTitle>
            <BookOpen className="h-4 w-4 text-muted-foreground" />
          </CardHeader>
          <CardContent>
            <div className="text-2xl font-bold">{mockData.admin.totalTeachers}</div>
            <p className="text-xs text-muted-foreground">5 new hires this month</p>
          </CardContent>
        </Card>
        <Card>
          <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
            <CardTitle className="text-sm font-medium">Active Classes</CardTitle>
            <Calendar className="h-4 w-4 text-muted-foreground" />
          </CardHeader>
          <CardContent>
            <div className="text-2xl font-bold">{mockData.admin.totalClasses}</div>
            <p className="text-xs text-muted-foreground">All grade levels</p>
          </CardContent>
        </Card>
        <Card>
          <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
            <CardTitle className="text-sm font-medium">Monthly Revenue</CardTitle>
            <DollarSign className="h-4 w-4 text-muted-foreground" />
          </CardHeader>
          <CardContent>
            <div className="text-2xl font-bold">${mockData.admin.revenue.toLocaleString()}</div>
            <p className="text-xs text-muted-foreground">+8% from last month</p>
          </CardContent>
        </Card>
      </div>

      <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {/* Recent Activities */}
        <Card>
          <CardHeader>
            <CardTitle>Recent Activities</CardTitle>
            <CardDescription>Latest system activities</CardDescription>
          </CardHeader>
          <CardContent>
            <div className="space-y-4">
              {mockData.admin.recentActivities.map((activity, index) => (
                <div key={index} className="flex items-start space-x-3">
                  <div className={`w-2 h-2 rounded-full mt-2 ${
                    activity.type === 'enrollment' ? 'bg-blue-500' :
                    activity.type === 'grade' ? 'bg-green-500' : 'bg-purple-500'
                  }`} />
                  <div className="flex-1">
                    <div className="text-sm font-medium">{activity.description}</div>
                    <div className="text-xs text-gray-500">{activity.time}</div>
                  </div>
                </div>
              ))}
            </div>
          </CardContent>
        </Card>

        {/* Quick Actions */}
        <Card>
          <CardHeader>
            <CardTitle>Quick Actions</CardTitle>
            <CardDescription>Administrative shortcuts</CardDescription>
          </CardHeader>
          <CardContent>
            <div className="grid grid-cols-2 gap-4">
              <Button variant="outline" className="h-20 flex flex-col gap-2">
                <Users className="h-6 w-6" />
                <span className="text-sm">Manage Students</span>
              </Button>
              <Button variant="outline" className="h-20 flex flex-col gap-2">
                <BookOpen className="h-6 w-6" />
                <span className="text-sm">Manage Teachers</span>
              </Button>
              <Button variant="outline" className="h-20 flex flex-col gap-2">
                <BarChart3 className="h-6 w-6" />
                <span className="text-sm">View Reports</span>
              </Button>
              <Button variant="outline" className="h-20 flex flex-col gap-2">
                <Settings className="h-6 w-6" />
                <span className="text-sm">System Settings</span>
              </Button>
            </div>
          </CardContent>
        </Card>
      </div>
    </div>
  )

  return (
    <div className="min-h-screen bg-gray-50">
      {/* Top Navigation */}
      <nav className="bg-white border-b px-6 py-4">
        <div className="flex items-center justify-between">
          <div className="flex items-center space-x-4">
            <Link href="/" className="flex items-center space-x-2">
              <GraduationCap className="h-8 w-8 text-blue-600" />
              <span className="text-xl font-bold">EduHelp</span>
            </Link>
            <div className="h-6 w-px bg-gray-300" />
            <span className="text-sm text-gray-600">School Management Dashboard</span>
          </div>
          <div className="flex items-center space-x-4">
            <Button variant="ghost" size="sm">
              <Bell className="h-4 w-4" />
            </Button>
            <Button variant="ghost" size="sm">
              <Settings className="h-4 w-4" />
            </Button>
            <Button variant="ghost" size="sm">
              <LogOut className="h-4 w-4" />
            </Button>
          </div>
        </div>
      </nav>

      {/* Main Content */}
      <main className="p-6">
        <div className="max-w-7xl mx-auto">
          {renderRoleSelector()}

          {currentRole === 'student' && renderStudentDashboard()}
          {currentRole === 'teacher' && renderTeacherDashboard()}
          {currentRole === 'admin' && renderAdminDashboard()}
        </div>
      </main>
    </div>
  )
}

function DashboardLoading() {
  return (
    <div className="min-h-screen bg-gray-50 flex items-center justify-center">
      <div className="text-center">
        <GraduationCap className="h-12 w-12 text-blue-600 mx-auto mb-4 animate-pulse" />
        <p className="text-gray-600">Loading dashboard...</p>
      </div>
    </div>
  )
}

export default function DashboardPage() {
  return (
    <Suspense fallback={<DashboardLoading />}>
      <DashboardContent />
    </Suspense>
  )
}
